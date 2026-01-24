<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Stuff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        // Validasi cart tidak kosong
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $stuffId => $item) {
            $product = Stuff::findOrFail($stuffId);
            if ($product) {
                $quantity = (int) $item['quantity'];
                $price = (int) $item['price'];
                $subtotal = $quantity * $price;

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        // Ambil payment methods yang aktif
        $payments = Payment::where('is_active', true)->get();

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'total' => $total,
            'payments' => $payments,
        ]);
    }

    /**
     * Proses checkout dan simpan ke database
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        // Validasi cart tidak kosong
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        // Validasi payment_id
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
        ]);

        // Validasi stok dan siapkan data
        $cartItems = [];
        $total = 0;

        foreach ($cart as $stuffId => $item) {
            $product = Stuff::findOrFail($stuffId);
            $quantity = (int) $item['quantity'];
            $price = (int) $item['price'];

            // Validasi stok
            if ($product->stok_barang < $quantity) {
                return back()->with('error', "Stok {$product->nama_barang} tidak mencukupi! Stok tersedia: {$product->stok_barang} unit");
            }

            $subtotal = $quantity * $price;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }

        // Proses transaksi dalam database transaction
        try {
            DB::beginTransaction();

            // 1. Buat record di tabel sales
            $sale = Sale::create([
                'payment_id' => $validated['payment_id'],
                'user_id' => Auth::id(),
                'tanggal' => Carbon::today(),
                'total' => $total,
                'status_transaksi' => 'Selesai', // Langsung Selesai sesuai permintaan
            ]);

            // 2. Buat record di tabel detail_transactions dan kurangi stok
            foreach ($cartItems as $item) {
                // Insert detail transaction
                DetailTransaction::create([
                    'stuff_id' => $item['product']->id,
                    'sale_id' => $sale->id,
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['price'],
                    'sub_total' => $item['subtotal'],
                ]);

                // Kurangi stok produk
                $item['product']->decrement('stok_barang', $item['quantity']);

                // Update status ketersediaan jika stok habis
                $item['product']->refresh();
                if ($item['product']->stok_barang == 0) {
                    $item['product']->update(['status_ketersediaan' => 'Habis']);
                }
            }

            DB::commit();

            // Clear cart session
            session()->forget('cart');

            // Redirect ke halaman sukses dengan sale ID
            return redirect()->route('checkout.success', $sale->id)->with('success', 'Pembayaran berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Halaman sukses checkout
     */
    public function success($id)
    {
        $sale = Sale::with(['detailTransactions.stuff', 'payment', 'user'])
            ->findOrFail($id);

        // Pastikan sale ini milik user yang login
        if ($sale->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', [
            'sale' => $sale,
        ]);
    }
}
