<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight">
                Detail Produk {{ $product->nama_barang }}
            </h2>
            <a href="{{ route('productList.index') }}"
                class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col lg:flex-row">

                    <div class="lg:w-1/2 relative bg-gray-50 dark:bg-gray-900/50">
                        <div class="aspect-square w-full">
                            <img class="w-full h-full object-cover"
                                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x600?text=No+Image' }}"
                                alt="{{ $product->nama_barang }}">
                        </div>

                        <div class="absolute top-6 left-6">
                            @php
                                $statusColor = [
                                    'Tersedia' => 'bg-emerald-500',
                                    'Habis' => 'bg-rose-500',
                                    'Pre_Order' => 'bg-amber-500'
                                ][$product->status_ketersediaan] ?? 'bg-gray-500';
                            @endphp
                            <span
                                class="{{ $statusColor }} text-white text-xs font-black uppercase tracking-[0.2em] px-4 py-2 rounded-full shadow-lg">
                                {{ str_replace('_', ' ', $product->status_ketersediaan) }}
                            </span>
                        </div>
                    </div>

                    <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col">
                        <div class="mb-6">
                            <span
                                class="text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-widest">ID
                                Produk: #{{ $product->id }}</span>
                            <h1
                                class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-white mt-2 leading-tight">
                                {{ $product->nama_barang }}
                            </h1>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase">Harga Satuan
                                </p>
                                <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">
                                    Rp {{ number_format($product->harga_barang, 0, ',', '.') }}
                                </p>
                            </div>
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                                <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase">Stok Gudang
                                </p>
                                <p class="text-2xl font-black text-gray-900 dark:text-white mt-1">
                                    {{ $product->stok_barang }} <span
                                        class="text-sm font-normal text-gray-400 tracking-normal">Unit</span>
                                </p>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h4 class="text-gray-900 dark:text-white font-bold mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                Deskripsi Produk
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed italic">
                                "{{ $product->keterangan_barang ?? 'Tidak ada deskripsi tambahan untuk produk ini.' }}"
                            </p>
                        </div>

                        <div class="mt-auto space-y-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 font-medium">Tanggal Kedaluwarsa (Exp):</span>
                                <span
                                    class="text-rose-600 dark:text-rose-400 font-bold bg-rose-50 dark:bg-rose-900/20 px-3 py-1 rounded-lg">
                                    {{ \Carbon\Carbon::parse($product->exp_barang)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm italic text-gray-400">
                                <span>Terakhir diperbarui:</span>
                                <span>{{ $product->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex gap-3">
                                @csrf
                                <div class="flex-1">
                                    <label for="quantity"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Jumlah
                                    </label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ $product->stok_barang }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                        class="w-full px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                        {{ $product->status_ketersediaan == 'Habis' || $product->stok_barang == 0 ? 'disabled' : '' }}>
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>