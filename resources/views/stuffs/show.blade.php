<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Barang: ') }} {{ $product->nama_barang }}
            </h2>
            <a href="{{ route('stuffs.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <div class="md:col-span-1">
                            <div class="sticky top-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Foto Produk</h3>
                                <div
                                    class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->nama_barang }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3
                                    class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Informasi Umum</h3>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 mt-4">
                                    <div>
                                        <dt class="text-sm font-sm text-gray-500 dark:text-gray-400">Nama Barang</dt>
                                        <dd class="text-md font-semibold text-gray-900 dark:text-white">
                                            {{ $product->nama_barang }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-sm text-gray-500 dark:text-gray-400">Kategori</dt>
                                        <dd class="text-md font-semibold text-gray-900 dark:text-white">
                                            {{ $product->category->nama_kategori ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-sm text-gray-500 dark:text-gray-400">Harga Satuan</dt>
                                        <dd class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Rp
                                            {{ number_format($product->harga_barang, 0, ',', '.') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-sm text-gray-500 dark:text-gray-400">Stok Tersedia</dt>
                                        <dd class="text-md font-semibold text-gray-900 dark:text-white">
                                            {{ $product->stok_barang }} Unit</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-sm text-gray-500 dark:text-gray-400">Tanggal Kadaluarsa
                                        </dt>
                                        <dd class="text-md font-semibold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($product->exp_barang)->format('d F Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-sm text-gray-500 dark:text-gray-400">Status Ketersediaan
                                        </dt>
                                        <dd class="mt-1">
                                            @php
                                                $statusColors = [
                                                    'Tersedia' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                    'Habis' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                    'Pre_Order' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                                ];
                                                $color = $statusColors[$product->status_ketersediaan] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $color }}">
                                                {{ str_replace('_', ' ', $product->status_ketersediaan) }}
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h3
                                    class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Keterangan Produk</h3>
                                <p class="mt-4 text-gray-600 dark:text-gray-400 leading-relaxed italic">
                                    {{ $product->keterangan_barang ?: 'Tidak ada deskripsi untuk barang ini.' }}
                                </p>
                            </div>

                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                                <a href="{{ route('stuffs.edit', $product->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 transition shadow-sm">
                                    Edit Data
                                </a>
                                <form action="{{ route('stuffs.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-sm">
                                        Hapus Barang
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>