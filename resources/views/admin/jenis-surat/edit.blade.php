<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Edit Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Jenis Surat</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Edit data jenis surat: {{ $jenisSurat->nama_jenis }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.jenis-surat.show', $jenisSurat) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                👁 Lihat
                            </a>
                            <a href="{{ route('admin.jenis-surat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ← Kembali
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.jenis-surat.update', $jenisSurat) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Jenis -->
                        <div>
                            <label for="nama_jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Jenis Surat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_jenis" id="nama_jenis" value="{{ old('nama_jenis', $jenisSurat->nama_jenis) }}" required
                                   placeholder="Contoh: Surat Undangan"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('nama_jenis') border-red-500 @enderror">
                            @error('nama_jenis')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                <!-- Kode Jenis -->
                <div>
                    <label for="kode_jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kode Jenis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kode_jenis" id="kode_jenis" value="{{ old('kode_jenis', $jenisSurat->kode_jenis) }}" required
                           maxlength="10" placeholder="Contoh: UND"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('kode_jenis') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Kode unik maksimal 10 karakter. Contoh: UND, KET, EDR
                    </p>
                    @error('kode_jenis')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              placeholder="Deskripsi singkat tentang jenis surat ini..."
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $jenisSurat->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-white">
                        Status Aktif
                    </label>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Jenis surat yang aktif akan muncul dalam pilihan saat menambah surat masuk/keluar
                </p>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.jenis-surat.show', $jenisSurat) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                Lihat Detail
                            </a>
                            <a href="{{ route('admin.jenis-surat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                Update Jenis Surat
                            </button>
                        </div>
                    </form>

                    <!-- Usage Information -->
        @if($jenisSurat->suratMasuk->count() > 0 || $jenisSurat->suratKeluar->count() > 0)
            <div class="mt-6 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Informasi Penggunaan
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>Jenis surat ini sedang digunakan oleh:</p>
                            <ul class="list-disc pl-5 mt-1">
                                @if($jenisSurat->suratMasuk->count() > 0)
                                    <li>{{ $jenisSurat->suratMasuk->count() }} surat masuk</li>
                                @endif
                                @if($jenisSurat->suratKeluar->count() > 0)
                                    <li>{{ $jenisSurat->suratKeluar->count() }} surat keluar</li>
                                @endif
                            </ul>
                            <p class="mt-2">
                                <strong>Perhatian:</strong> Jenis surat tidak dapat dihapus karena masih digunakan oleh data surat yang ada.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Usage -->
        @if($jenisSurat->suratMasuk->count() > 0 || $jenisSurat->suratKeluar->count() > 0)
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($jenisSurat->suratMasuk->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Surat Masuk Terbaru</h3>
                        <div class="space-y-3">
                            @foreach($jenisSurat->suratMasuk->take(3) as $surat)
                                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $surat->nomor_surat }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $surat->perihal }}</p>
                                    </div>
                                    <a href="{{ route('admin.surat-masuk.show', $surat) }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-xs">
                                        Lihat
                                    </a>
                                </div>
                            @endforeach
                            @if($jenisSurat->suratMasuk->count() > 3)
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    dan {{ $jenisSurat->suratMasuk->count() - 3 }} surat lainnya
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($jenisSurat->suratKeluar->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Surat Keluar Terbaru</h3>
                        <div class="space-y-3">
                            @foreach($jenisSurat->suratKeluar->take(3) as $surat)
                                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $surat->nomor_surat }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $surat->perihal }}</p>
                                    </div>
                                    <a href="{{ route('admin.surat-keluar.show', $surat) }}" class="text-green-600 hover:text-green-500 dark:text-green-400 text-xs">
                                        Lihat
                                    </a>
                                </div>
                            @endforeach
                            @if($jenisSurat->suratKeluar->count() > 3)
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    dan {{ $jenisSurat->suratKeluar->count() - 3 }} surat lainnya
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Convert kode to uppercase
document.getElementById('kode_jenis').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});
</script>
@endpush

</x-admin-layout>