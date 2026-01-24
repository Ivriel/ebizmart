<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight">
                    {{ __('Checkout') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi informasi pembayaran Anda.</p>
            </div>
            <a href="{{ route('cart.index') }}"
                class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Keranjang
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Order Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Detail Pesanan
                            </h3>
                            
                            <div class="space-y-4">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                        <div class="w-20 h-20 flex-shrink-0 bg-gray-100 dark:bg-gray-900 rounded-xl overflow-hidden">
                                            <img class="w-full h-full object-cover"
                                                src="{{ $item['product']->image ? asset('storage/' . $item['product']->image) : 'https://via.placeholder.com/200x200?text=No+Image' }}"
                                                alt="{{ $item['product']->nama_barang }}">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $item['product']->nama_barang }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item['quantity'] }} x Rp {{ number_format($item['product']->harga_barang, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Metode Pembayaran
                            </h3>
                            
                            @if($payments->count() > 0)
                                <div class="space-y-3">
                                    @foreach($payments as $payment)
                                        <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ old('payment_id') == $payment->id ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-600' }}">
                                            <input type="radio" 
                                                name="payment_id" 
                                                value="{{ $payment->id }}" 
                                                {{ old('payment_id') == $payment->id ? 'checked' : '' }}
                                                class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                                            <span class="ml-3 text-gray-900 dark:text-white font-semibold">
                                                {{ $payment->nama_pembayaran }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('payment_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            @else
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <p>Tidak ada metode pembayaran yang tersedia.</p>
                                    <p class="text-sm mt-2">Silakan hubungi administrator.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-4">
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
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">Total Harga:</span>
                                        <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $payments->count() == 0 ? 'disabled' : '' }}>
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Proses Pembayaran
                            </button>

                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-4">
                                Dengan melanjutkan, Anda menyetujui untuk melakukan pembayaran.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>