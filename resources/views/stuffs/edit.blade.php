<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('stuffs.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full"
                                    :value="old('nama_barang', $product->nama_barang)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
                            </div>

                            <div>
                                <x-input-label for="category_id" :value="__('Kategori')" />
                                <select id="category_id" name="category_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div>
                                <x-input-label for="harga_barang" :value="__('Harga Barang (Rp)')" />
                                <x-text-input id="harga_barang" name="harga_barang" type="number"
                                    class="mt-1 block w-full" :value="old('harga_barang', $product->harga_barang)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga_barang')" />
                            </div>

                            <div>
                                <x-input-label for="stok_barang" :value="__('Stok Barang')" />
                                <x-text-input id="stok_barang" name="stok_barang" type="number"
                                    class="mt-1 block w-full" :value="old('stok_barang', $product->stok_barang)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('stok_barang')" />
                            </div>

                            <div>
                                <x-input-label for="exp_barang" :value="__('Tanggal Kadaluarsa')" />
                                <x-text-input id="exp_barang" name="exp_barang" type="date" class="mt-1 block w-full"
                                    :value="old('exp_barang', $product->exp_barang)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('exp_barang')" />
                            </div>

                            <div>
                                <x-input-label for="status_ketersediaan" :value="__('Status Ketersediaan')" />
                                <select id="status_ketersediaan" name="status_ketersediaan"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="Tersedia" {{ old('status_ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Habis" {{ old('status_ketersediaan', $product->status_ketersediaan) == 'Habis' ? 'selected' : '' }}>
                                        Habis</option>
                                    <option value="Pre_Order" {{ old('status_ketersediaan') == 'Pre_Order' ? 'selected' : '' }}>Pre-Order</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status_ketersediaan')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Foto Barang (Opsional)')" />
                            <input type="file" id="image" name="image"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div>
                            <x-input-label for="keterangan_barang" :value="__('Keterangan Barang')" />
                            <textarea id="keterangan_barang" name="keterangan_barang" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('keterangan_barang', $product->keterangan_barang) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan_barang')" />
                        </div>

                        <div
                            class="flex items-center justify-end gap-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('stuffs.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Barang') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>