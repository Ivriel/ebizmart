<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="nama_kategori" :value="__('Nama Kategori')" />
                            <x-text-input id="nama_kategori" name="nama_kategori" type="text" class="mt-1 block w-full"
                                :value="old('nama_kategori')" required autofocus autocomplete="nama_kategori" />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('nama_kategori')" />
                        </div>
                        <x-primary-button>Simpan</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>