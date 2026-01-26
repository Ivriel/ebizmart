<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Katalog Produk') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan pantau stok barang Anda dengan mudah.</p>
            </div>
            <a href="#"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($products as $item)
                    <div
                        class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col transform hover:-translate-y-2">

                        <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-900">
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x400?text=No+Image' }}"
                                alt="{{ $item->nama_barang }}" />

                            <div class="absolute top-4 left-4">
                                @php
                                    $statusClasses = [
                                        'Tersedia' => 'bg-emerald-500 text-white ring-emerald-500/20',
                                        'Habis' => 'bg-rose-500 text-white ring-rose-500/20',
                                        'Pre-Order' => 'bg-amber-500 text-white ring-amber-500/20',
                                    ];
                                    $statusLabel =
                                        $item->status_ketersediaan == 'Tersedia'
                                        ? 'Ready'
                                        : ($item->status_ketersediaan == 'Habis'
                                            ? 'Out of Stock'
                                            : 'Pre-Order');
                                    $currentClass =
                                        $statusClasses[$item->status_ketersediaan] ?? 'bg-gray-500 text-white';
                                @endphp
                                <span
                                    class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg {{ $currentClass }} ring-4">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <span
                                class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-[0.2em] mb-2 block">
                                {{ $item->category->nama_kategori ?? 'Umum' }}
                            </span>

                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white leading-snug mb-3 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $item->nama_barang }}
                            </h3>

                            <div class="flex flex-col mt-auto gap-1">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm font-medium text-gray-500">Rp</span>
                                    <span class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                                        {{ number_format($item->harga_barang, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Stok: <span
                                            class="font-bold text-gray-700 dark:text-gray-200">{{ $item->stok_barang }}
                                            unit</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-0 flex gap-3">
                            <a href="{{ route('productList.show', $item->id) }}"
                                class="w-full text-center py-2.5 text-sm font-bold text-white bg-gray-900 dark:bg-indigo-600 hover:bg-gray-800 dark:hover:bg-indigo-700 rounded-xl transition-all shadow-md">
                                Lihat Detail
                            </a>

                            <form action="{{ route('wishlist.add', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="py-2.5 px-3 text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-900/40 rounded-xl transition-all shadow-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </form>

                            <form action="{{ route('cart.add', $item->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-md"
                                    {{ $item->status_ketersediaan == 'Habis' || $item->stok_barang == 0 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full flex flex-col items-center justify-center py-24 bg-gray-50/50 dark:bg-gray-800/50 rounded-[2rem] border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-full shadow-xl mb-6">
                            <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Belum ada produk</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Mulai isi katalog dengan menambahkan produk
                            pertama Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>