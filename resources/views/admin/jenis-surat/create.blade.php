<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Tambah Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Jenis Surat</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Tambahkan jenis surat baru untuk arsip</p>
                        </div>
                        <a href="{{ route('admin.jenis-surat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            ← Kembali
                        </a>
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
                    <form action="{{ route('admin.jenis-surat.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nama Jenis -->
                        <div>
                            <label for="nama_jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Jenis Surat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_jenis" id="nama_jenis" value="{{ old('nama_jenis') }}" required
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
                            <input type="text" name="kode_jenis" id="kode_jenis" value="{{ old('kode_jenis') }}" required
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
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
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
                            <a href="{{ route('admin.jenis-surat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                Simpan Jenis Surat
                            </button>
                        </div>
                    </form>

                    <!-- Quick Add Examples -->
                    <div class="mt-6 bg-purple-50 dark:bg-purple-900 border border-purple-200 dark:border-purple-700 rounded-lg p-4">
                        <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-purple-800 dark:text-purple-200">
                        Contoh Jenis Surat Umum Desa
                    </h3>
                    <div class="mt-2 text-sm text-purple-700 dark:text-purple-300">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <p><strong>UND</strong> - Surat Undangan</p>
                                <p><strong>KET</strong> - Surat Keterangan</p>
                                <p><strong>EDR</strong> - Surat Edaran</p>
                                <p><strong>TGS</strong> - Surat Tugas</p>
                                <p><strong>PER</strong> - Surat Permohonan</p>
                            </div>
                            <div class="space-y-1">
                                <p><strong>KEP</strong> - Surat Keputusan</p>
                                <p><strong>LAP</strong> - Surat Laporan</p>
                                <p><strong>BRT</strong> - Surat Pemberitahuan</p>
                                <p><strong>REK</strong> - Surat Rekomendasi</p>
                                <p><strong>LAN</strong> - Surat Lainnya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <button onclick="fillExample('Surat Undangan', 'UND', 'Surat undangan kegiatan resmi desa')" 
                        class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Isi Contoh Undangan</p>
                    </div>
                </button>

                <button onclick="fillExample('Surat Keterangan', 'KET', 'Surat keterangan berbagai keperluan warga')" 
                        class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Isi Contoh Keterangan</p>
                    </div>
                </button>

                <button onclick="fillExample('Surat Edaran', 'EDR', 'Surat edaran pengumuman atau pemberitahuan')" 
                        class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Isi Contoh Edaran</p>
                    </div>
                </button>

                <button onclick="clearForm()" 
                        class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Bersihkan Form</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function fillExample(nama, kode, deskripsi) {
    document.getElementById('nama_jenis').value = nama;
    document.getElementById('kode_jenis').value = kode;
    document.getElementById('deskripsi').value = deskripsi;
    document.getElementById('is_active').checked = true;
}

function clearForm() {
    document.getElementById('nama_jenis').value = '';
    document.getElementById('kode_jenis').value = '';
    document.getElementById('deskripsi').value = '';
    document.getElementById('is_active').checked = true;
}

// Auto-generate kode from nama
document.getElementById('nama_jenis').addEventListener('input', function() {
    const nama = this.value;
    const kodeField = document.getElementById('kode_jenis');
    
    // Only auto-generate if kode field is empty
    if (!kodeField.value && nama.length > 0) {
        let kode = '';
        const words = nama.split(' ');
        
        if (words.length === 1) {
            // Single word, take first 3 characters
            kode = words[0].substring(0, 3).toUpperCase();
        } else {
            // Multiple words, take first character of each word
            words.forEach(word => {
                if (word.length > 0) {
                    kode += word.charAt(0).toUpperCase();
                }
            });
            // Limit to 10 characters
            kode = kode.substring(0, 10);
        }
        
        kodeField.value = kode;
    }
});

// Convert kode to uppercase
document.getElementById('kode_jenis').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});
</script>
@endpush

</x-admin-layout>