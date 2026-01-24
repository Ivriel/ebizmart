<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight">
            {{ __('Pembayaran Berhasil') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div
                class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-green-800 dark:text-green-200">Pembayaran Berhasil!</h3>
                        <p class="text-green-700 dark:text-green-300 mt-1">Terima kasih atas pembelian Anda.</p>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Detail Transaksi</h3>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">ID Transaksi</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">#{{ $sale->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($sale->tanggal)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Metode Pembayaran</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $sale->payment->nama_pembayaran }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            {{ $sale->status_transaksi }}
                        </span>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Item yang Dibeli:</h4>
                    <div class="space-y-3">
                        @foreach($sale->detailTransactions as $detail)
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden flex-shrink-0">
                                        <img class="w-full h-full object-cover"
                                            src="{{ $detail->stuff->image ? asset('storage/' . $detail->stuff->image) : 'https://via.placeholder.com/200x200?text=No+Image' }}"
                                            alt="{{ $detail->stuff->nama_barang }}">
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $detail->stuff->nama_barang }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $detail->jumlah }} x Rp
                                            {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <p class="font-bold text-indigo-600 dark:text-indigo-400">
                                    Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900 dark:text-white">Total Pembayaran:</span>
                        <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <a href="{{ route('productList.index') }}"
                    class="flex-1 text-center py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg">
                    Lanjut Belanja
                </a>
                <a href="{{ route('dashboard') }}"
                    class="flex-1 text-center py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all">
                    Ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>