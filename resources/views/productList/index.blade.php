<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 py-4">
            <div:::>
                <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Katalog Produk') }}
                </h2>
                </p>
    </x-slot>

    <div class="my-8 mx-4 flex flex-col md:flex-row gap-4 text-white">
        <form action="{{ route('productList.index') }}" method="GET" class="flex-grow flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk favoritmu..."
                class="w-full rounded-xl border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl">Cari</button>
        </form>

        <form action="{{ route('productList.index') }}" method="GET">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="sort" onchange="this.form.submit()"
                class="rounded-xl border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <option value="">Terbaru</option>
                <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
            </select>
        </form>
    </div>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('warning'))
                <div
                    class="mb-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-200 px-4 py-3 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($products as $item)
                    <div
                        class="group bg-white dark:bg-gray-800 rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col">

                        <div class="relative aspect-[4/5] overflow-hidden">
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x500?text=No+Image' }}"
                                alt="{{ $item->nama_barang }}" />

                            <div class="absolute top-5 left-5">
                                @php
                                    $statusConfig = [
                                        'Tersedia' => ['bg' => 'bg-emerald-500/90', 'label' => 'READY'],
                                        'Habis' => ['bg' => 'bg-rose-500/90', 'label' => 'OUT OF STOCK'],
                                        'Pre-Order' => ['bg' => 'bg-amber-500/90', 'label' => 'PRE-ORDER'],
                                    ];
                                    $config = $statusConfig[$item->status_ketersediaan] ?? [
                                        'bg' => 'bg-gray-500/90',
                                        'label' => 'UNKNOWN',
                                    ];
                                @endphp
                                <span
                                    class="backdrop-blur-md {{ $config['bg'] }} text-white text-[10px] font-black px-4 py-1.5 rounded-full tracking-widest shadow-lg">
                                    {{ $config['label'] }}
                                </span>
                            </div>

                            <form action="{{ route('wishlist.add', $item->id) }}" method="POST"
                                class="absolute top-5 right-5">
                                @csrf
                                <button type="submit"
                                    class="p-3 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-2xl text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="p-7 flex flex-col flex-grow">
                            <div class="mb-4">
                                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em]">
                                    {{ $item->category->nama_kategori ?? 'Umum' }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-1 line-clamp-2 leading-tight">
                                    {{ $item->nama_barang }}
                                </h3>
                            </div>

                            <div class="mt-auto">
                                <div class="flex items-end justify-between mb-6">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium mb-1">Harga Terbaik</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-indigo-600 font-bold text-sm">Rp</span>
                                            <span class="text-2xl font-black text-gray-900 dark:text-white">
                                                {{ number_format($item->harga_barang, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Stok
                                        </p>
                                        <p class="text-sm font-black text-gray-700 dark:text-gray-200">
                                            {{ $item->stok_barang }} <span
                                                class="text-[10px] font-normal text-gray-400">Unit</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-5 gap-2">
                                    <a href="{{ route('productList.show', $item->id) }}"
                                        class="col-span-2 py-3.5 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white text-xs font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                        Detail
                                    </a>
                                    <form action="{{ route('cart.add', $item->id) }}" method="POST" class="col-span-3">
                                        @csrf
                                        <button type="submit" {{ $item->status_ketersediaan == 'Habis' || $item->stok_barang == 0 ? 'disabled' : '' }}
                                            class="w-full py-3.5 bg-indigo-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 disabled:opacity-50 disabled:shadow-none transition-all flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Beli Sekarang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-8 rounded-full mb-6">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            Produk tidak ditemukan
                        </h3>
                    </div>
                @endforelse
            </div>
            <div class="mt-10">
                Test
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>