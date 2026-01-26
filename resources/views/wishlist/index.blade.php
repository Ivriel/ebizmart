<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if($wishlists->isEmpty())
                        <p class="text-center py-4">Belum ada barang di wishlist kamu.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($wishlists as $item)
                                <div
                                    class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900 shadow-sm">
                                    <div class="mb-4">
                                        <h4 class="text-lg font-bold">{{ $item->stuff->nama_barang }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Ditambahkan pada: {{ $item->created_at->format('d M Y H:i:s') }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                            Rp{{ number_format($item->stuff->harga_barang, 0, ',', '.') }}
                                        </span>

                                        <div class="flex space-x-2">
                                            <a href="{{ route('productList.show', $item->stuff_id) }}"
                                                class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-700 text-xs rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                                Lihat
                                            </a>

                                            @if (auth()->guard()->user()->role === 'pelanggan')
                                                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus {{ $item->stuff->nama_barang }} dari wishlist?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded-md hover:bg-red-700 transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>