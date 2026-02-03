<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-red-500">
        <div class="text-gray-500 dark:text-gray-400">Stok Menipis</div>
        <div class="text-3xl font-bold text-red-600">{{ $stok_tipis }}</div>
        <div class="text-xs text-gray-400 mt-1">Item perlu restock</div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
        <div class="text-gray-500 dark:text-gray-400">Total Produk</div>
        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $total_barang }}</div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
        <div class="text-gray-500 dark:text-gray-400">Total User</div>
        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $total_user }}</div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Update Barang Terakhir</h3>
            <a href="{{ url('/stuffs') }}" class="text-sm text-blue-500 hover:underline">Kelola Semua Barang &rarr;</a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Nama Barang</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barang_terbaru as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->nama_barang }}</td>
                            <td class="px-6 py-4 {{ $item->stok_barang < 5 ? 'text-red-500 font-bold' : '' }}">
                                {{ $item->stok_barang }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-xs {{ $item->status_ketersediaan == 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->status_ketersediaan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('productList.show', $item->id) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 mt-5 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Update Transaksi Terakhir</h3>
            <a href="{{ url('/sales') }}" class="text-sm text-blue-500 hover:underline">Kelola Semua Transaksi
                &rarr;</a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi_terbaru as $transaction)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d F Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $transaction->user->nama_user }}
                            </td>
                            <td class="px-6 py-4">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('admin.sales.show', $item->id) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>