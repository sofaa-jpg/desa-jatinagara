<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Detail Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Surat Masuk</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $suratMasuk->nomor_surat }}</p>
                        </div>
                        <div class="flex space-x-3">
                            @if($suratMasuk->file_surat)
                                <a href="{{ route('admin.surat-masuk.download', $suratMasuk) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    📥 Download File
                                </a>
                            @endif
                            <a href="{{ route('admin.surat-masuk.edit', $suratMasuk) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ✏️ Edit
                            </a>
                            <a href="{{ route('admin.surat-masuk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ← Kembali
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Detail Surat -->
                        <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Informasi Dasar Surat
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Surat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->nomor_surat }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Surat</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $suratMasuk->jenisSurat->kode_jenis }}
                                </span>
                                <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->jenisSurat->nama_jenis }}</span>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Perihal</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->perihal }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Pengirim</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->pengirim }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Alamat Pengirim</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->alamat_pengirim ?: '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Surat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->tanggal_surat->format('d F Y') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Terima</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->tanggal_terima->format('d F Y') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sifat Surat</label>
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($suratMasuk->sifat_surat === 'Penting') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                @elseif($suratMasuk->sifat_surat === 'Segera') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @elseif($suratMasuk->sifat_surat === 'Rahasia') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                {{ $suratMasuk->sifat_surat }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status Disposisi</label>
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($suratMasuk->status_disposisi === 'Belum') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @elseif($suratMasuk->status_disposisi === 'Sudah') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">
                                {{ $suratMasuk->status_disposisi }}
                            </span>
                        </div>
                    </div>

                    @if($suratMasuk->isi_ringkas)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Isi Ringkas Surat</label>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $suratMasuk->isi_ringkas }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informasi Disposisi -->
                @if($suratMasuk->status_disposisi !== 'Belum')
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Disposisi</h3>
                            <button onclick="showDisposisiModal()" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm">
                                Edit Disposisi
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Disposisi Kepada</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->disposisi_kepada ?: '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Disposisi</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $suratMasuk->tanggal_disposisi ? $suratMasuk->tanggal_disposisi->format('d F Y') : '-' }}
                                </p>
                            </div>

                            @if($suratMasuk->instruksi_disposisi)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Instruksi Disposisi</label>
                                    <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $suratMasuk->instruksi_disposisi }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Catatan -->
                @if($suratMasuk->catatan)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Catatan
                        </h3>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $suratMasuk->catatan }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- File Surat -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">File Surat</h3>
                    
                    @if($suratMasuk->file_surat)
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $suratMasuk->file_surat }}</p>
                            <a href="{{ route('admin.surat-masuk.download', $suratMasuk) }}" 
                               class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada file</p>
                        </div>
                    @endif
                </div>

                <!-- Informasi Metadata -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Metadata</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->created_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diubah</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratMasuk->updated_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID Surat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $suratMasuk->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.surat-masuk.edit', $suratMasuk) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Surat
                        </a>

                        @if($suratMasuk->status_disposisi === 'Belum')
                            <button onclick="showDisposisiModal()" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Buat Disposisi
                            </button>
                        @endif

                        <button onclick="deleteSurat()" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-red-400 dark:border-red-600 dark:hover:bg-red-900">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Surat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Disposisi -->
<div id="disposisiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-[500px] shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Disposisi Surat</h3>
            <form id="disposisiForm" class="space-y-4">
                @csrf
                <div>
                    <label for="status_disposisi_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status Disposisi <span class="text-red-500">*</span>
                    </label>
                    <select id="status_disposisi_modal" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="Belum" {{ $suratMasuk->status_disposisi == 'Belum' ? 'selected' : '' }}>Belum</option>
                        <option value="Sudah" {{ $suratMasuk->status_disposisi == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                        <option value="Selesai" {{ $suratMasuk->status_disposisi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div>
                    <label for="disposisi_kepada_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Disposisi Kepada
                    </label>
                    <input type="text" id="disposisi_kepada_modal" value="{{ $suratMasuk->disposisi_kepada }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="tanggal_disposisi_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tanggal Disposisi
                    </label>
                    <input type="date" id="tanggal_disposisi_modal" value="{{ $suratMasuk->tanggal_disposisi ? $suratMasuk->tanggal_disposisi->format('Y-m-d') : '' }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="instruksi_disposisi_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Instruksi Disposisi
                    </label>
                    <textarea id="instruksi_disposisi_modal" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $suratMasuk->instruksi_disposisi }}</textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeDisposisiModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                        Update Disposisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-center space-x-3 px-4 py-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                    Batal
                </button>
                <form action="{{ route('admin.surat-masuk.destroy', $suratMasuk) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150 ease-in-out">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Modal functions
function showDisposisiModal() {
    document.getElementById('disposisiModal').classList.remove('hidden');
}

function closeDisposisiModal() {
    document.getElementById('disposisiModal').classList.add('hidden');
}

function deleteSurat() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Update disposisi
document.getElementById('disposisiForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('status_disposisi', document.getElementById('status_disposisi_modal').value);
    formData.append('disposisi_kepada', document.getElementById('disposisi_kepada_modal').value);
    formData.append('tanggal_disposisi', document.getElementById('tanggal_disposisi_modal').value);
    formData.append('instruksi_disposisi', document.getElementById('instruksi_disposisi_modal').value);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');

    fetch('{{ route("admin.surat-masuk.update-disposisi", $suratMasuk) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengupdate disposisi: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate disposisi');
    });
});

// Close modals when clicking outside
document.getElementById('disposisiModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDisposisiModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>