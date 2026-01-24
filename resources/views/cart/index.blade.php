<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Keranjang Belanja') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola produk yang ingin Anda beli.</p>
            </div>
            @if (count($cartItems) > 0)
                <form action="{{ route('cart.clear') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin mengosongkan keranjang?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Kosongkan Keranjang
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @if (count($cartItems) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($cartItems as $item)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                <div class="p-6 flex flex-col md:flex-row gap-6">
                                    <!-- Product Image -->
                                    <div
                                        class="w-full md:w-32 h-32 flex-shrink-0 bg-gray-100 dark:bg-gray-900 rounded-xl overflow-hidden">
                                        <img class="w-full h-full object-cover"
                                            src="{{ $item['product']->image ? asset('storage/' . $item['product']->image) : 'https://via.placeholder.com/200x200?text=No+Image' }}"
                                            alt="{{ $item['product']->nama_barang }}">
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                                {{ $item['product']->nama_barang }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                                Stok tersedia: <span
                                                    class="font-semibold text-gray-700 dark:text-gray-300">{{ $item['product']->stok_barang }}
                                                    unit</span>
                                            </p>
                                            <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($item['product']->harga_barang, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Quantity & Actions -->
                                        <div
                                            class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                            <div class="flex items-center gap-3">
                                                <label for="quantity-{{ $item['product']->id }}"
                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    Jumlah:
                                                </label>
                                                <form action="{{ route('cart.update', $item['product']->id) }}"
                                                    method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" id="quantity-{{ $item['product']->id }}"
                                                        name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                        max="{{ $item['product']->stok_barang }}"
                                                        onchange="this.form.submit()"
                                                        class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white text-center">
                                                </form>
                                            </div>

                                            <div class="flex items-center gap-4">
                                                <div class="text-right">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Subtotal</p>
                                                    <p class="text-xl font-black text-gray-900 dark:text-white">
                                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                    </p>
                                                </div>

                                                <form action="{{ route('cart.remove', $item['product']->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                        onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Ringkasan Pesanan
                            </h3>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                    <span>Total Item:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ count($cartItems) }} produk
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                    <span>Total Quantity:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ array_sum(array_column($cartItems, 'quantity')) }} unit
                                    </span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">Total
                                            Harga:</span>
                                        <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}"
                                class="w-full block text-center py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl">
                                Lanjut ke Checkout
                            </a>

                            <a href="{{ route('productList.index') }}"
                                class="w-full block text-center py-3 mt-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold rounded-xl transition-all">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="p-6 bg-gray-100 dark:bg-gray-700 rounded-full mb-6">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Keranjang Anda Kosong</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai belanja dan tambahkan produk ke keranjang
                            Anda.</p>
                        <a href="{{ route('productList.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
