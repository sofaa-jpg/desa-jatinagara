<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Detail Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Jenis Surat</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $jenisSurat->nama_jenis }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.jenis-surat.edit', $jenisSurat) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ✏️ Edit
                            </a>
                            <a href="{{ route('admin.jenis-surat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ← Kembali
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Detail Jenis Surat -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Informasi Jenis Surat
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Jenis</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $jenisSurat->nama_jenis }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kode Jenis</label>
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                {{ $jenisSurat->kode_jenis }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jenisSurat->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                    {{ $jenisSurat->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <button onclick="toggleStatus()" class="ml-2 text-blue-600 hover:text-blue-500 dark:text-blue-400 text-xs">
                                    {{ $jenisSurat->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Total Penggunaan</label>
                            <div class="mt-1 flex items-center space-x-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $jenisSurat->suratMasuk->count() }} Masuk
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    {{ $jenisSurat->suratKeluar->count() }} Keluar
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($jenisSurat->deskripsi)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</label>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $jenisSurat->deskripsi }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Statistik Penggunaan -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Statistik Penggunaan
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Surat Masuk Chart -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <svg class="w-20 h-20" viewBox="0 0 42 42">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#e5e7eb" stroke-width="3"/>
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#3b82f6" stroke-width="3"
                                            stroke-dasharray="{{ $jenisSurat->suratMasuk->count() > 0 ? min(($jenisSurat->suratMasuk->count() / max($jenisSurat->suratMasuk->count() + $jenisSurat->suratKeluar->count(), 1)) * 100, 100) : 0 }}, 100"
                                            stroke-dashoffset="25"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-lg font-bold text-blue-600">{{ $jenisSurat->suratMasuk->count() }}</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Surat Masuk</p>
                        </div>

                        <!-- Surat Keluar Chart -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <svg class="w-20 h-20" viewBox="0 0 42 42">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#e5e7eb" stroke-width="3"/>
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#10b981" stroke-width="3"
                                            stroke-dasharray="{{ $jenisSurat->suratKeluar->count() > 0 ? min(($jenisSurat->suratKeluar->count() / max($jenisSurat->suratMasuk->count() + $jenisSurat->suratKeluar->count(), 1)) * 100, 100) : 0 }}, 100"
                                            stroke-dashoffset="25"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-lg font-bold text-green-600">{{ $jenisSurat->suratKeluar->count() }}</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Surat Keluar</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $jenisSurat->suratMasuk->count() + $jenisSurat->suratKeluar->count() }}</p>
                            <p class="text-sm text-blue-800 dark:text-blue-200">Total Surat</p>
                        </div>
                        
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-300">
                                {{ $jenisSurat->suratMasuk->filter(function($item) { return $item->created_at->month == now()->month && $item->created_at->year == now()->year; })->count() + $jenisSurat->suratKeluar->filter(function($item) { return $item->created_at->month == now()->month && $item->created_at->year == now()->year; })->count() }}
                            </p>
                            <p class="text-sm text-green-800 dark:text-green-200">Bulan Ini</p>
                        </div>
                        
                        <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-300">
                                {{ $jenisSurat->suratMasuk->filter(function($item) { return $item->created_at->year == now()->year; })->count() + $jenisSurat->suratKeluar->filter(function($item) { return $item->created_at->year == now()->year; })->count() }}
                            </p>
                            <p class="text-sm text-purple-800 dark:text-purple-200">Tahun Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.jenis-surat.edit', $jenisSurat) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Jenis Surat
                        </a>

                        <button onclick="toggleStatus()" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ $jenisSurat->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>

                        @if($jenisSurat->suratMasuk->count() == 0 && $jenisSurat->suratKeluar->count() == 0)
                            <button onclick="deleteJenis()" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-gray-700 dark:text-red-400 dark:border-red-600 dark:hover:bg-red-900">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Jenis Surat
                            </button>
                        @else
                            <div class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-600 cursor-not-allowed">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                </svg>
                                Tidak Dapat Dihapus
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Metadata -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Metadata</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $jenisSurat->created_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diubah</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $jenisSurat->updated_at->format('d F Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID Jenis</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $jenisSurat->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Navigasi</h3>
                    
                    <div class="space-y-2">
                        @if($jenisSurat->suratMasuk->count() > 0)
                            <a href="{{ route('admin.surat-masuk.index', ['jenis_surat_id' => $jenisSurat->id]) }}" 
                               class="block w-full text-left px-3 py-2 text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 rounded">
                                📨 Lihat Surat Masuk ({{ $jenisSurat->suratMasuk->count() }})
                            </a>
                        @endif
                        
                        @if($jenisSurat->suratKeluar->count() > 0)
                            <a href="{{ route('admin.surat-keluar.index', ['jenis_surat_id' => $jenisSurat->id]) }}" 
                               class="block w-full text-left px-3 py-2 text-sm text-green-600 hover:text-green-500 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 rounded">
                                📤 Lihat Surat Keluar ({{ $jenisSurat->suratKeluar->count() }})
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.jenis-surat.create') }}" 
                           class="block w-full text-left px-3 py-2 text-sm text-purple-600 hover:text-purple-500 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900 rounded">
                            ➕ Tambah Jenis Surat Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Surat Lists -->
        @if($jenisSurat->suratMasuk->count() > 0 || $jenisSurat->suratKeluar->count() > 0)
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                @if($jenisSurat->suratMasuk->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Surat Masuk Terbaru</h3>
                            <a href="{{ route('admin.surat-masuk.index', ['jenis_surat_id' => $jenisSurat->id]) }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm">
                                Lihat Semua →
                            </a>
                        </div>
                        <div class="space-y-3">
                            @foreach($jenisSurat->suratMasuk->take(5) as $surat)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $surat->nomor_surat }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($surat->perihal, 40) }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $surat->tanggal_terima->format('d/m/Y') }}</p>
                                    </div>
                                    <a href="{{ route('admin.surat-masuk.show', $surat) }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 ml-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($jenisSurat->suratKeluar->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Surat Keluar Terbaru</h3>
                            <a href="{{ route('admin.surat-keluar.index', ['jenis_surat_id' => $jenisSurat->id]) }}" class="text-green-600 hover:text-green-500 dark:text-green-400 text-sm">
                                Lihat Semua →
                            </a>
                        </div>
                        <div class="space-y-3">
                            @foreach($jenisSurat->suratKeluar->take(5) as $surat)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $surat->nomor_surat }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($surat->perihal, 40) }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $surat->tanggal_surat->format('d/m/Y') }}</p>
                                    </div>
                                    <a href="{{ route('admin.surat-keluar.show', $surat) }}" class="text-green-600 hover:text-green-500 dark:text-green-400 ml-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin menghapus jenis surat ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-center space-x-3 px-4 py-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out">
                    Batal
                </button>
                <form action="{{ route('admin.jenis-surat.destroy', $jenisSurat) }}" method="POST" style="display: inline;">
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
function toggleStatus() {
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');

    fetch('{{ route("admin.jenis-surat.toggle-status", $jenisSurat) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengubah status: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status');
    });
}

function deleteJenis() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush
</x-admin-layout>