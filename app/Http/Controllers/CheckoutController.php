<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Stuff;
use Barryvdh\DomPDF\Facade\Pdf;
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
                'tanggal' => Carbon::now(),
                'total' => $total,
                'status_transaksi' => 'Belum Bayar',
            ]);

            foreach ($cartItems as $item) {

                DetailTransaction::create([
                    'stuff_id' => $item['product']->id,
                    'sale_id' => $sale->id,
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['price'],
                    'sub_total' => $item['subtotal'],
                ]);
            }

            DB::commit();

            session()->forget('cart');

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

        if ($sale->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', [
            'sale' => $sale,
        ]);
    }

    public function printReceipt($id)
    {
        $sale = Sale::with(['user', 'detailTransactions.stuff'])->findOrFail($id);
        $data = [
            'sale' => $sale,
            'tanggal' => now()->format('d/m/Y H:i:s'),
        ];

        $pdf = Pdf::loadView('checkout.receipt', $data);
        $pdf->setPaper([0, 0, 600, 800], 'portrait');

        return $pdf->stream('struk-transaksi-'.$sale->id.'.pdf');
    }
}
