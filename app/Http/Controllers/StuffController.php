<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stuff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StuffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('stuffs.index', [
            'products' => Stuff::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stuffs.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'harga_barang' => 'required|numeric|min:0',
            'stok_barang' => 'required|numeric|min:0',
            'exp_barang' => 'required|date|after_or_equal:now',
            'status_ketersediaan' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan_barang' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stuffs', 'public');
        }

        Stuff::create([
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'harga_barang' => $request->harga_barang,
            'stok_barang' => $request->stok_barang,
            'exp_barang' => $request->exp_barang,
            'status_ketersediaan' => $request->status_ketersediaan,
            'image' => $imagePath,
            'keterangan_barang' => $request->keterangan_barang,
        ]);

        return redirect()->route('stuffs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stuff $stuff)
    {
        return view('stuffs.show', [
            'product' => $stuff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stuff $stuff)
    {
        return view('stuffs.edit', [
            'product' => $stuff,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stuff $stuff)
    {
        $validatedRequest = $request->validate([
            'nama_barang' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'harga_barang' => 'required|numeric|min:0',
            'stok_barang' => 'required|numeric|min:0',
            'exp_barang' => 'required|date|after_or_equal:now',
            'status_ketersediaan' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan_barang' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // hapus image lama
            if ($stuff->image && Storage::disk('public')) {
                Storage::disk('public')->delete($stuff->image);
            }

            $path = $request->file('image')->store('stuffs', 'public');
            $validatedRequest['image'] = $path;
        }

        $stuff->update($validatedRequest);

        return redirect()->route('stuffs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteId = Stuff::findOrFail($id);
        $deleteId->delete();

        return redirect()->route('stuffs.index');
    }
}
