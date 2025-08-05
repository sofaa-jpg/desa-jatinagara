<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Edit Surat Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Surat Keluar</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Edit data surat keluar: {{ $suratKeluar->nomor_surat }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.surat-keluar.show', $suratKeluar) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                👁 Lihat
                            </a>
                            <a href="{{ route('admin.surat-keluar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
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
                    <form action="{{ route('admin.surat-keluar.update', $suratKeluar) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Dasar -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Dasar Surat</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomor Surat -->
                        <div>
                            <label for="nomor_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nomor Surat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('nomor_surat') border-red-500 @enderror">
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
                                        class="mt-1 block w-full rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('jenis_surat_id') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Surat</option>
                                    @foreach($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id }}" {{ old('jenis_surat_id', $suratKeluar->jenis_surat_id) == $jenis->id ? 'selected' : '' }}>
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
                            <input type="text" name="perihal" id="perihal" value="{{ old('perihal', $suratKeluar->perihal) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('perihal') border-red-500 @enderror">
                            @error('perihal')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tujuan -->
                        <div>
                            <label for="tujuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tujuan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tujuan" id="tujuan" value="{{ old('tujuan', $suratKeluar->tujuan) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('tujuan') border-red-500 @enderror">
                            @error('tujuan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Tujuan -->
                        <div>
                            <label for="alamat_tujuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Alamat Tujuan
                            </label>
                            <input type="text" name="alamat_tujuan" id="alamat_tujuan" value="{{ old('alamat_tujuan', $suratKeluar->alamat_tujuan) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('alamat_tujuan') border-red-500 @enderror">
                            @error('alamat_tujuan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Surat -->
                        <div>
                            <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Surat <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat->format('Y-m-d')) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('tanggal_surat') border-red-500 @enderror">
                            @error('tanggal_surat')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Kirim -->
                        <div>
                            <label for="tanggal_kirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tanggal Kirim
                            </label>
                            <input type="date" name="tanggal_kirim" id="tanggal_kirim" value="{{ old('tanggal_kirim', $suratKeluar->tanggal_kirim ? $suratKeluar->tanggal_kirim->format('Y-m-d') : '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('tanggal_kirim') border-red-500 @enderror">
                            @error('tanggal_kirim')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sifat Surat -->
                        <div>
                            <label for="sifat_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sifat Surat <span class="text-red-500">*</span>
                            </label>
                            <select name="sifat_surat" id="sifat_surat" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('sifat_surat') border-red-500 @enderror">
                                <option value="">Pilih Sifat Surat</option>
                                <option value="Biasa" {{ old('sifat_surat', $suratKeluar->sifat_surat) == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="Penting" {{ old('sifat_surat', $suratKeluar->sifat_surat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Segera" {{ old('sifat_surat', $suratKeluar->sifat_surat) == 'Segera' ? 'selected' : '' }}>Segera</option>
                                <option value="Rahasia" {{ old('sifat_surat', $suratKeluar->sifat_surat) == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                            </select>
                            @error('sifat_surat')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Kirim -->
                        <div>
                            <label for="status_kirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status Kirim <span class="text-red-500">*</span>
                            </label>
                            <select name="status_kirim" id="status_kirim" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('status_kirim') border-red-500 @enderror">
                                <option value="Draft" {{ old('status_kirim', $suratKeluar->status_kirim) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Dikirim" {{ old('status_kirim', $suratKeluar->status_kirim) == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="Diterima" {{ old('status_kirim', $suratKeluar->status_kirim) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            </select>
                            @error('status_kirim')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penandatangan -->
                        <div>
                            <label for="penandatangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Penandatangan
                            </label>
                            <input type="text" name="penandatangan" id="penandatangan" value="{{ old('penandatangan', $suratKeluar->penandatangan) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('penandatangan') border-red-500 @enderror">
                            @error('penandatangan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tembusan -->
                        <div>
                            <label for="tembusan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tembusan
                            </label>
                            <input type="text" name="tembusan" id="tembusan" value="{{ old('tembusan', $suratKeluar->tembusan) }}"
                                   placeholder="Pisahkan dengan koma jika lebih dari satu"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('tembusan') border-red-500 @enderror">
                            @error('tembusan')
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
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('isi_ringkas') border-red-500 @enderror">{{ old('isi_ringkas', $suratKeluar->isi_ringkas) }}</textarea>
                    @error('isi_ringkas')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Surat -->
                <div>
                    <label for="file_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        File Surat
                    </label>
                    @if($suratKeluar->file_surat)
                        <div class="mt-1 mb-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">File saat ini: {{ $suratKeluar->file_surat }}</span>
                                <a href="{{ route('admin.surat-keluar.download', $suratKeluar) }}" class="text-green-600 hover:text-green-500 dark:text-green-400 text-sm">
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="file_surat" id="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300 @error('file_surat') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 5MB. Kosongkan jika tidak ingin mengubah file.
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
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 @error('catatan') border-red-500 @enderror">{{ old('catatan', $suratKeluar->catatan) }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('admin.surat-keluar.show', $suratKeluar) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        Lihat Detail
                    </a>
                    <a href="{{ route('admin.surat-keluar.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        Update Surat Keluar
                    </button>
                </div>
            </form>
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
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div>
                    <label for="kode_jenis_baru" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kode Jenis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kode_jenis_baru" maxlength="10" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div>
                    <label for="deskripsi_baru" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi_baru" rows="2"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddJenisModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150 ease-in-out">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-fill tanggal kirim when status is Dikirim or Diterima
document.getElementById('status_kirim').addEventListener('change', function() {
    const tanggalKirimField = document.getElementById('tanggal_kirim');
    
    if (this.value === 'Dikirim' || this.value === 'Diterima') {
        if (!tanggalKirimField.value) {
            tanggalKirimField.value = new Date().toISOString().split('T')[0];
        }
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

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>