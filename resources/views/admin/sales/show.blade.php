<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Transaksi #') }}{{ $sale->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="mb-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Informasi Transaksi</h3>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">ID Transaksi</p>
                                <p class="font-semibold dark:text-gray-200">#{{ $sale->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal</p>
                                <p class="font-semibold dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Customer</p>
                                <p class="font-semibold dark:text-gray-200">{{ $sale->user->nama_user }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">{{ $sale->user->username }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Metode Pembayaran</p>
                                <p class="font-semibold dark:text-gray-200">{{ $sale->payment->nama_pembayaran }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Status Transaksi</p>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($sale->status_transaksi == 'Selesai') bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300
                                    @elseif($sale->status_transaksi == 'Belum Bayar') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300
                                    @elseif($sale->status_transaksi == 'Dalam Proses') bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300
                                    @endif">
                                    {{ $sale->status_transaksi }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Pembayaran</p>
                                <p class="font-bold text-lg text-green-600 dark:text-green-400">Rp
                                    {{ number_format($sale->total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <h4 class="text-md font-semibold mb-3 mt-6 dark:text-gray-200">Detail Produk</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Produk</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Harga</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Jumlah</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($sale->detailTransactions as $detail)
                                        <tr>
                                            <td class="px-4 py-3 text-sm dark:text-gray-300">
                                                {{ $detail->stuff->nama_barang }}
                                            </td>
                                            <td class="px-4 py-3 text-sm dark:text-gray-300">Rp
                                                {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm dark:text-gray-300">{{ $detail->jumlah }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold dark:text-gray-200">Rp
                                                {{ number_format($detail->sub_total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Update Status</h3>

                        <form method="POST" action="{{ route('admin.sales.updateStatus', $sale->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status Transaksi
                                </label>
                                <select name="status_transaksi"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm"
                                    required>
                                    <option value="Belum Bayar" {{ $sale->status_transaksi == 'Belum Bayar' ? 'selected' : '' }}>
                                        Belum Bayar
                                    </option>
                                    <option value="Dalam Proses" {{ $sale->status_transaksi == 'Dalam Proses' ? 'selected' : '' }}>
                                        Dalam Proses
                                    </option>
                                    <option value="Selesai" {{ $sale->status_transaksi == 'Selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                    <option value="Gagal" {{ $sale->status_transaksi == 'Gagal' ? 'selected' : '' }}>
                                        Gagal
                                    </option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-500 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                                Update Status
                            </button>
                        </form>

                        <div class="mt-4">
                            <a href="{{ route('checkout.print', $sale->id) }}" target="_blank"
                                class="block text-center w-full bg-gray-500 dark:bg-gray-600 hover:bg-gray-600 dark:hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition">
                                Cetak Invoice
                            </a>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.sales.index') }}"
                                class="block text-center w-full bg-gray-500 dark:bg-gray-600 hover:bg-gray-600 dark:hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition">
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>