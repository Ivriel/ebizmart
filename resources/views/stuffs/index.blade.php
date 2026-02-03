<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Barang') }}
            </h2>
            <a href="{{ route('stuffs.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Barang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold">ID</th>
                                <th scope="col" class="px-6 py-4 font-bold">Gambar</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Barang</th>
                                <th scope="col" class="px-6 py-4 font-bold">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-bold">Harga</th>
                                <th scope="col" class="px-6 py-4 font-bold">Stok</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 text-center font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($products as $product)
                                <tr
                                    class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                        #{{ $product->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->nama_barang }}"
                                                class="h-12 w-12 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300 font-semibold">
                                        {{ $product->nama_barang }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-mono text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($product->harga_barang, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->stok_barang }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusColors = [
                                                'Tersedia' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'Habis' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                'Pre_Order' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                            ];
                                            $color = $statusColors[$product->status_ketersediaan] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ str_replace('_', ' ', $product->status_ketersediaan) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-3">
                                            {{-- Button Detail --}}
                                            <a href="{{ route('stuffs.show', $product->id) }}"
                                                class="text-blue-500 hover:text-blue-600 transition-colors"
                                                title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            {{-- Button Edit --}}
                                            <a href="{{ route('stuffs.edit', $product->id) }}"
                                                class="text-amber-500 hover:text-amber-600 transition-colors" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            {{-- Button Hapus --}}
                                            <form action="{{ route('stuffs.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus barang {{ $product->nama_barang }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-600 transition-colors" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>