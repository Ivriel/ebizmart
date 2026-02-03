<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stuff;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stuff::with('category');
        $category = Category::all();

        $query->when($request->search, function ($q) use ($request) {
            return $q->where('nama_barang', 'like', '%'.$request->search.'%');
        });

        if ($request->sort == 'termurah') {
            $query->orderBy('harga_barang', 'asc');
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('harga_barang', 'desc');
        } elseif ($request->category) {
            $query->where('category_id', $request->category);
        } else {
            $query->latest(); // defaultnya produk terbaru
        }

        $products = $query->paginate(8)->withQueryString();

        return view('productList.index', [
            'products' => $products,
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Panggil with() DULU, baru findOrFail()
        $product = Stuff::with('category')->findOrFail($id);

        return view('productList.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
