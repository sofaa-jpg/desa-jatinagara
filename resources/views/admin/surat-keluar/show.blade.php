<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Detail Surat Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Surat Keluar</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $suratKeluar->nomor_surat }}</p>
                        </div>
                        <div class="flex space-x-3">
                            @if($suratKeluar->file_surat)
                                <a href="{{ route('admin.surat-keluar.download', $suratKeluar) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    📥 Download File
                                </a>
                            @endif
                            <a href="{{ route('admin.surat-keluar.edit', $suratKeluar) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ✏️ Edit
                            </a>
                            <a href="{{ route('admin.surat-keluar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
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
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->nomor_surat }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Surat</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    {{ $suratKeluar->jenisSurat->kode_jenis }}
                                </span>
                                <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->jenisSurat->nama_jenis }}</span>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Perihal</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->perihal }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tujuan</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->tujuan }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Alamat Tujuan</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->alamat_tujuan ?: '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Surat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->tanggal_surat->format('d F Y') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kirim</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $suratKeluar->tanggal_kirim ? $suratKeluar->tanggal_kirim->format('d F Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sifat Surat</label>
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($suratKeluar->sifat_surat === 'Penting') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                @elseif($suratKeluar->sifat_surat === 'Segera') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @elseif($suratKeluar->sifat_surat === 'Rahasia') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                {{ $suratKeluar->sifat_surat }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status Kirim</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($suratKeluar->status_kirim === 'Draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @elseif($suratKeluar->status_kirim === 'Dikirim') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                    @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">
                                    {{ $suratKeluar->status_kirim }}
                                </span>
                                <button onclick="showStatusModal()" class="ml-2 text-blue-600 hover:text-blue-500 dark:text-blue-400 text-xs">
                                    Update
                                </button>
                            </div>
                        </div>

                        @if($suratKeluar->penandatangan)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Penandatangan</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->penandatangan }}</p>
                            </div>
                        @endif

                        @if($suratKeluar->tembusan)
                            <div class="{{ $suratKeluar->penandatangan ? '' : 'md:col-span-2' }}">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tembusan</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->tembusan }}</p>
                            </div>
                        @endif
                    </div>

                    @if($suratKeluar->isi_ringkas)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Isi Ringkas Surat</label>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $suratKeluar->isi_ringkas }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Catatan -->
                @if($suratKeluar->catatan)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Catatan
                        </h3>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $suratKeluar->catatan }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- File Surat -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">File Surat</h3>
                    
                    @if($suratKeluar->file_surat)
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $suratKeluar->file_surat }}</p>
                            <a href="{{ route('admin.surat-keluar.download', $suratKeluar) }}" 
                               class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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

                <!-- Status Progress -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Progress Status</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Draft</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Surat dibuat</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 rounded-full {{ in_array($suratKeluar->status_kirim, ['Dikirim', 'Diterima']) ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Dikirim</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $suratKeluar->tanggal_kirim ? $suratKeluar->tanggal_kirim->format('d/m/Y') : 'Belum dikirim' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 rounded-full {{ $suratKeluar->status_kirim === 'Diterima' ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Diterima</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $suratKeluar->status_kirim === 'Diterima' ? 'Sudah diterima' : 'Belum dikonfirmasi' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Metadata -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Metadata</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->created_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diubah</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $suratKeluar->updated_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID Surat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $suratKeluar->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.surat-keluar.edit', $suratKeluar) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Surat
                        </a>

                        <button onclick="showStatusModal()" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Status
                        </button>

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

<!-- Modal Update Status -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Status Surat</h3>
            <form id="statusForm" class="space-y-4">
                @csrf
                <div>
                    <label for="status_kirim_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status Kirim <span class="text-red-500">*</span>
                    </label>
                    <select id="status_kirim_modal" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="Draft" {{ $suratKeluar->status_kirim == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Dikirim" {{ $suratKeluar->status_kirim == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="Diterima" {{ $suratKeluar->status_kirim == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_kirim_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tanggal Kirim
                    </label>
                    <input type="date" id="tanggal_kirim_modal" value="{{ $suratKeluar->tanggal_kirim ? $suratKeluar->tanggal_kirim->format('Y-m-d') : '' }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150 ease-in-out">
                        Update Status
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
                <form action="{{ route('admin.surat-keluar.destroy', $suratKeluar) }}" method="POST" style="display: inline;">
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
function showStatusModal() {
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

function deleteSurat() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Update status
document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('status_kirim', document.getElementById('status_kirim_modal').value);
    formData.append('tanggal_kirim', document.getElementById('tanggal_kirim_modal').value);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');

    fetch('{{ route("admin.surat-keluar.update-status", $suratKeluar) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengupdate status: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate status');
    });
});

// Auto-fill tanggal kirim when status changes
document.getElementById('status_kirim_modal').addEventListener('change', function() {
    const tanggalKirimField = document.getElementById('tanggal_kirim_modal');
    
    if ((this.value === 'Dikirim' || this.value === 'Diterima') && !tanggalKirimField.value) {
        tanggalKirimField.value = new Date().toISOString().split('T')[0];
    }
});

// Close modals when clicking outside
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
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