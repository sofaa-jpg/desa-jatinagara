<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Tambah Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Surat Masuk</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Tambahkan surat masuk baru ke arsip</p>
                        </div>
                        <a href="{{ route('admin.surat-masuk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
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
                    <form action="{{ route('admin.surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Informasi Dasar -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Dasar Surat</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nomor Surat -->
                                <div>
                            <label for="nomor_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nomor Surat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nomor_surat') border-red-500 @enderror">
                            @error('nomor_surat')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Surat -->
                        <div>
                            <label for="jenis_surat_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Jenis Surat <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <select name="jenis_surat_id" id="jenis_surat_id" required
                                        class="mt-1 block w-full rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_surat_id') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Surat</option>
                                    @foreach($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id }}" {{ old('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="showAddJenisModal()" 
                                        class="mt-1 inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 dark:border-gray-600 rounded-r-md bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('jenis_surat_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Perihal -->
                        <div class="md:col-span-2">
                            <label for="perihal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Perihal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="perihal" id="perihal" value="{{ old('perihal') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('perihal') border-red-500 @enderror">
                            @error('perihal')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pengirim -->
                        <div>
                            <label for="pengirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pengirim <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pengirim" id="pengirim" value="{{ old('pengirim') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pengirim') border-red-500 @enderror">
                            @error('pengirim')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Pengirim -->
                        <div>
                            <label for="alamat_pengirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Alamat Pengirim
                            </label>
                            <input type="text" name="alamat_pengirim" id="alamat_pengirim" value="{{ old('alamat_pengirim') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('alamat_pengirim') border-red-500 @enderror">
                            @error('alamat_pengirim')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Surat -->
                        <div>
                            <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Surat <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_surat') border-red-500 @enderror">
                            @error('tanggal_surat')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Terima -->
                        <div>
                            <label for="tanggal_terima" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Terima <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_terima" id="tanggal_terima" value="{{ old('tanggal_terima', date('Y-m-d')) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_terima') border-red-500 @enderror">
                            @error('tanggal_terima')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sifat Surat -->
                        <div>
                            <label for="sifat_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sifat Surat <span class="text-red-500">*</span>
                            </label>
                            <select name="sifat_surat" id="sifat_surat" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sifat_surat') border-red-500 @enderror">
                                <option value="">Pilih Sifat Surat</option>
                                <option value="Biasa" {{ old('sifat_surat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="Penting" {{ old('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Segera" {{ old('sifat_surat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                                <option value="Rahasia" {{ old('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                            </select>
                            @error('sifat_surat')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Disposisi -->
                        <div>
                            <label for="status_disposisi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status Disposisi <span class="text-red-500">*</span>
                            </label>
                            <select name="status_disposisi" id="status_disposisi" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status_disposisi') border-red-500 @enderror">
                                <option value="Belum" {{ old('status_disposisi', 'Belum') == 'Belum' ? 'selected' : '' }}>Belum</option>
                                <option value="Sudah" {{ old('status_disposisi') == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                                <option value="Selesai" {{ old('status_disposisi') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_disposisi')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Isi Ringkas -->
                <div>
                    <label for="isi_ringkas" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Isi Ringkas Surat
                    </label>
                    <textarea name="isi_ringkas" id="isi_ringkas" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('isi_ringkas') border-red-500 @enderror">{{ old('isi_ringkas') }}</textarea>
                    @error('isi_ringkas')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Disposisi -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4" id="disposisiSection" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Disposisi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Disposisi Kepada -->
                        <div>
                            <label for="disposisi_kepada" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Disposisi Kepada
                            </label>
                            <input type="text" name="disposisi_kepada" id="disposisi_kepada" value="{{ old('disposisi_kepada') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('disposisi_kepada') border-red-500 @enderror">
                            @error('disposisi_kepada')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Disposisi -->
                        <div>
                            <label for="tanggal_disposisi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Disposisi
                            </label>
                            <input type="date" name="tanggal_disposisi" id="tanggal_disposisi" value="{{ old('tanggal_disposisi') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_disposisi') border-red-500 @enderror">
                            @error('tanggal_disposisi')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instruksi Disposisi -->
                        <div class="md:col-span-2">
                            <label for="instruksi_disposisi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Instruksi Disposisi
                            </label>
                            <textarea name="instruksi_disposisi" id="instruksi_disposisi" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('instruksi_disposisi') border-red-500 @enderror">{{ old('instruksi_disposisi') }}</textarea>
                            @error('instruksi_disposisi')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- File Surat -->
                <div>
                    <label for="file_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        File Surat
                    </label>
                    <input type="file" name="file_surat" id="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300 @error('file_surat') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 5MB.
                    </p>
                    @error('file_surat')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Catatan
                    </label>
                    <textarea name="catatan" id="catatan" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('admin.surat-masuk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        Simpan Surat Masuk
                        </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

<!-- Modal Tambah Jenis Surat -->
<div id="addJenisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah Jenis Surat Baru</h3>
            <form id="addJenisForm" class="space-y-4">
                <div>
                    <label for="nama_jenis_baru" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_jenis_baru" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="kode_jenis_baru" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kode Jenis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kode_jenis_baru" maxlength="10" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="deskripsi_baru" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi_baru" rows="2"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddJenisModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle disposisi section
document.getElementById('status_disposisi').addEventListener('change', function() {
    const disposisiSection = document.getElementById('disposisiSection');
    if (this.value === 'Sudah' || this.value === 'Selesai') {
        disposisiSection.style.display = 'block';
    } else {
        disposisiSection.style.display = 'none';
    }
});

// Trigger on page load
document.addEventListener('DOMContentLoaded', function() {
    const statusDisposisi = document.getElementById('status_disposisi');
    if (statusDisposisi.value === 'Sudah' || statusDisposisi.value === 'Selesai') {
        document.getElementById('disposisiSection').style.display = 'block';
    }
});

// Modal functions
function showAddJenisModal() {
    document.getElementById('addJenisModal').classList.remove('hidden');
}

function closeAddJenisModal() {
    document.getElementById('addJenisModal').classList.add('hidden');
    document.getElementById('addJenisForm').reset();
}

// Add new jenis surat
document.getElementById('addJenisForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('nama_jenis', document.getElementById('nama_jenis_baru').value);
    formData.append('kode_jenis', document.getElementById('kode_jenis_baru').value);
    formData.append('deskripsi', document.getElementById('deskripsi_baru').value);
    formData.append('is_active', true);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("admin.jenis-surat.store") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh jenis surat options
            location.reload();
        } else {
            alert('Gagal menambahkan jenis surat: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan jenis surat');
    });
});

// Close modal when clicking outside
document.getElementById('addJenisModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddJenisModal();
    }
});
</script>
@endpush

</x-admin-layout>