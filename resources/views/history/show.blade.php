<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Transaksi') }} #{{ $transaction->id }}
            </h2>
            <div class="flex items-center gap-2 no-print">
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-lg font-bold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print Browser
                </button>

                <a href="{{ route('checkout.print', $transaction->id) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                        </path>
                    </svg>
                    Download PDF
                </a>

                <a href="{{ route('history.index') }}" class="..."> Kembali </a>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {

            /* Sembunyikan Navigasi, Tombol, dan Footer bawaan aplikasi */
            nav,
            .no-print,
            header,
            button,
            a {
                display: none !important;
            }

            /* Hilangkan padding abu-abu di latar belakang body */
            body {
                background-color: white !important;
                color: black !important;
            }

            /* Hilangkan shadow dan border yang tidak perlu saat cetak */
            .shadow-sm,
            .rounded-2xl {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }

            /* Pastikan container mengambil lebar penuh */
            .max-w-4xl {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .py-12 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden mb-6 border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal</p>
                            <p class="font-bold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pembayaran</p>
                            <p class="font-bold text-indigo-600">
                                {{ $transaction->payment->nama_pembayaran ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pelanggan</p>
                            <p class="font-bold text-gray-900 dark:text-white">
                                {{ $transaction->user->nama_user ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
                            @php
                                $statusColor = match ($transaction->status_transaksi) {
                                    'Selesai' => 'text-green-500',
                                    'Belum Bayar' => 'text-red-500',
                                    default => 'text-amber-500',
                                };
                            @endphp
                            <span class="font-black uppercase {{ $statusColor }}">
                                {{ $transaction->status_transaksi }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-800">
                    <h3 class="font-bold text-gray-800 dark:text-white">Rincian Produk</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4 text-center">Harga Satuan</th>
                                <th class="px-6 py-4 text-center">Jumlah</th>
                                <th class="px-6 py-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                            @foreach ($detailTransaction as $detail)
                                <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-12 w-12 flex-shrink-0 rounded-lg overflow-hidden border border-gray-100 dark:border-gray-600 bg-gray-100">
                                                <img class="h-full w-full object-cover"
                                                    src="{{ $detail->stuff->image ? asset('storage/' . $detail->stuff->image) : 'https://via.placeholder.com/100' }}"
                                                    alt="{{ $detail->stuff->nama_barang }}">
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 dark:text-white leading-tight">
                                                    {{ $detail->stuff->nama_barang ?? 'Barang Terhapus' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">
                                                    ID: #{{ $detail->stuff_id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center dark:text-gray-300">
                                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 dark:text-gray-300 text-gray-800">
                                            {{ $detail->jumlah }} pcs
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-indigo-50/30 dark:bg-indigo-900/10">
                                <td colspan="3"
                                    class="px-6 py-6 text-right font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-xs">
                                    Total Keseluruhan
                                </td>
                                <td
                                    class="px-6 py-6 text-right text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400">Terima kasih telah melakukan pembelian melalui e-BizMart.</p>
            </div>
        </div>
    </div>
</x-app-layout>