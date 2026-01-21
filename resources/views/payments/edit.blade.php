<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Metode Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Gunakan method spoofing @method('PUT') untuk update --}}
                    <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama_pembayaran" :value="__('Nama Pembayaran')" />
                            <x-text-input id="nama_pembayaran" name="nama_pembayaran" type="text"
                                class="mt-1 block w-full" :value="old('nama_pembayaran', $payment->nama_pembayaran)"
                                required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_pembayaran')" />
                        </div>

                        <div>
                            <x-input-label for="is_active" :value="__('Status Aktif')" />
                            <select id="is_active" name="is_active"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">

                                {{-- Logika untuk otomatis memilih status berdasarkan data di database --}}
                                <option value="1" {{ old('is_active', $payment->is_active) == '1' ? 'selected' : '' }}>
                                    True (Aktif)
                                </option>
                                <option value="0" {{ old('is_active', $payment->is_active) == '0' ? 'selected' : '' }}>
                                    False (Non-Aktif)
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Perbarui Data') }}</x-primary-button>

                            <a href="{{ route('payments.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>