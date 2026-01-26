<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $user = auth()->guard()->user();

        if ($user->role === 'admin' || $user->role === 'owner') {
            $wishlists = Wishlist::with(['stuff.category', 'user'])
                ->latest()
                ->get();
        } else {
            $wishlists = Wishlist::with(['stuff.category', 'user'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('wishlist.index', [
            'wishlists' => $wishlists,
        ]);
    }

    public function add($id)
    {
        $user = auth()->guard()->user();
        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('stuff_id', $id)
            ->first();

        if ($existingWishlist) {
            return back()->with('warning', 'Produk sudah ada di wishlist!');
        }

        Wishlist::create([
            'user_id' => $user->id,
            'stuff_id' => $id,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke wishlist');
    }

    public function remove($id)
    {
        $user = auth()->guard()->user();

        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $wishlist->delete();

        return back()->with('success', 'Berhasil menghapus wishlist');
    }

    public function clear()
    {
        $user = auth()->guard()->user();

        Wishlist::where('user_id', $user->id)->delete();

        return back()->with('success', 'Wishlist berhasil dikosongkan!');
    }
}
