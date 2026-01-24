<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $stuffId => $item) {
            $product = Stuff::find($stuffId);
            if ($product) {
                // Pastikan quantity dan price adalah integer untuk perhitungan
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

        return view('cart.index', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    public function add(Request $request, $id)
    {
        $product = Stuff::findOrFail($id);

        // validasi stok
        $requestedQuantity = $request->input('quantity', 1);

        if ($product->stok_barang < $requestedQuantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        // kalau produk udah ada di cart, tambahin quantity nya
        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $requestedQuantity;

            // validasi total quantity tidak melebihi stok
            if ($newQuantity > $product->stok_barang) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }

            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'quantity' => (int) $requestedQuantity,
                'price' => (int) $product->harga_barang,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // update quantity di cart

    public function update(Request $request, $id)
    {
        $product = Stuff::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($id);
        }

        if ($product->stok_barang < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int) $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    // hapus item dari cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
