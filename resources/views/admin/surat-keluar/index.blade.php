<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Surat Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Surat Keluar</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola surat keluar desa</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.surat-keluar.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                + Tambah Surat Keluar
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Filter & Search -->
                    <form method="GET" action="{{ route('admin.surat-keluar.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pencarian</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       placeholder="Nomor surat, perihal, tujuan..."
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Jenis Surat -->
                            <div>
                                <label for="jenis_surat_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Surat</label>
                                <select name="jenis_surat_id" id="jenis_surat_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id }}" {{ request('jenis_surat_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sifat Surat -->
                            <div>
                                <label for="sifat_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sifat Surat</label>
                                <select name="sifat_surat" id="sifat_surat" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Sifat</option>
                                    <option value="Biasa" {{ request('sifat_surat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="Penting" {{ request('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="Segera" {{ request('sifat_surat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                                    <option value="Rahasia" {{ request('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                                </select>
                            </div>

                            <!-- Status Kirim -->
                            <div>
                                <label for="status_kirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Kirim</label>
                                <select name="status_kirim" id="status_kirim" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="Draft" {{ request('status_kirim') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Dikirim" {{ request('status_kirim') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="Diterima" {{ request('status_kirim') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Tanggal Mulai -->
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Tanggal Selesai -->
                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex space-x-3 mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                🔍 Filter
                            </button>
                            <a href="{{ route('admin.surat-keluar.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                🔄 Reset
                            </a>
                        </div>
                    </form>

                    <!-- Informasi hasil -->
                    @if(request()->hasAny(['search', 'jenis_surat_id', 'sifat_surat', 'status_kirim', 'tanggal_mulai', 'tanggal_selesai']))
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-md p-4 mb-6">
                            <p class="text-blue-700 dark:text-blue-300 text-sm">
                                📊 Menampilkan {{ $suratKeluar->total() }} dari {{ $suratKeluar->total() }} surat keluar
                                @if(request('search'))
                                    dengan pencarian "<strong>{{ request('search') }}</strong>"
                                @endif
                            </p>
                        </div>
                    @endif

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

        <!-- Tabel Surat Keluar -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Daftar Surat Keluar
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        ({{ $suratKeluar->total() }} surat)
                    </span>
                </h3>
            </div>

            @if($suratKeluar->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nomor & Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Perihal & Tujuan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jenis & Sifat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status Kirim
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    File
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($suratKeluar as $surat)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $surat->nomor_surat }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Surat: {{ $surat->tanggal_surat->format('d/m/Y') }}
                                    </div>
                                    @if($surat->tanggal_kirim)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Kirim: {{ $surat->tanggal_kirim->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ Str::limit($surat->perihal, 40) }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $surat->tujuan }}
                                    </div>
                                    @if($surat->alamat_tujuan)
                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                            {{ Str::limit($surat->alamat_tujuan, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $surat->jenisSurat->nama_jenis }}
                                    </div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($surat->sifat_surat === 'Penting') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                        @elseif($surat->sifat_surat === 'Segera') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                        @elseif($surat->sifat_surat === 'Rahasia') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                        {{ $surat->sifat_surat }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($surat->status_kirim === 'Draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @elseif($surat->status_kirim === 'Dikirim') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                        @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">
                                        {{ $surat->status_kirim }}
                                    </span>
                                    @if($surat->penandatangan)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Ttd: {{ $surat->penandatangan }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($surat->file_surat)
                                        <a href="{{ route('admin.surat-keluar.download', $surat) }}" 
                                           class="text-green-600 hover:text-green-500 dark:text-green-400">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.surat-keluar.show', $surat) }}" 
                                           class="text-green-600 hover:text-green-500 dark:text-green-400" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.surat-keluar.edit', $surat) }}" 
                                           class="text-yellow-600 hover:text-yellow-500 dark:text-yellow-400" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button data-action="update-status" data-id="{{ $surat->id }}"
                                                class="text-blue-600 hover:text-blue-500 dark:text-blue-400" title="Update Status">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </button>
                                        <button data-action="delete-surat" data-id="{{ $surat->id }}"
                                                class="text-red-600 hover:text-red-500 dark:text-red-400" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $suratKeluar->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada surat keluar</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan menambahkan surat keluar pertama.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.surat-keluar.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Surat Keluar
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Status Surat</h3>
            <form id="statusForm" class="space-y-4">
                <div>
                    <label for="status_kirim_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status Kirim <span class="text-red-500">*</span>
                    </label>
                    <select id="status_kirim_modal" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="Draft">Draft</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Diterima">Diterima</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal_kirim_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tanggal Kirim
                    </label>
                    <input type="date" id="tanggal_kirim_modal"
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
                <form id="deleteForm" method="POST" style="display: inline;">
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

let currentSuratId = null;

// Global functions for onclick handlers (fallback)
window.closeStatusModal = function() {
    document.getElementById('statusModal').classList.add('hidden');
    currentSuratId = null;
}

window.closeDeleteModal = function() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    
    // Event delegation for action buttons
    document.addEventListener('click', function(e) {
        const button = e.target.closest('button[data-action]');
        if (!button) return;
        
        const action = button.getAttribute('data-action');
        const id = button.getAttribute('data-id');
        
        
        
        if (action === 'update-status') {
            currentSuratId = id;
            document.getElementById('statusModal').classList.remove('hidden');
        } else if (action === 'delete-surat') {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/admin/surat-keluar/${id}`;
            modal.classList.remove('hidden');
        }
    });

// Update status surat
document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!currentSuratId) {
        alert('ID surat tidak ditemukan');
        return;
    }
    
    const formData = new FormData();
    formData.append('status_kirim', document.getElementById('status_kirim_modal').value);
    formData.append('tanggal_kirim', document.getElementById('tanggal_kirim_modal').value);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');

    

    fetch(`/admin/surat-keluar/${currentSuratId}/status`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        
        if (data.success) {
            alert('Status berhasil diperbarui');
            location.reload();
        } else {
            alert('Gagal mengupdate status: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate status: ' + error.message);
    });
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
});
</script>
@endpush

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>