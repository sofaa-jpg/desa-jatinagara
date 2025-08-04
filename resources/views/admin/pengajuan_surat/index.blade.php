<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Kelola Pengajuan Surat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $statistik['total'] }}</div>
                        <div class="text-sm text-gray-600">Total Pengajuan</div>
                    </div>
                </div>
                <div class="bg-yellow-50 overflow-hidden shadow-sm rounded-lg border border-yellow-200">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-yellow-700">{{ $statistik['pending'] }}</div>
                        <div class="text-sm text-yellow-600">Menunggu</div>
                    </div>
                </div>
                <div class="bg-blue-50 overflow-hidden shadow-sm rounded-lg border border-blue-200">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-700">{{ $statistik['diproses'] }}</div>
                        <div class="text-sm text-blue-600">Diproses</div>
                    </div>
                </div>
                <div class="bg-green-50 overflow-hidden shadow-sm rounded-lg border border-green-200">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-green-700">{{ $statistik['selesai'] }}</div>
                        <div class="text-sm text-green-600">Selesai</div>
                    </div>
                </div>
                <div class="bg-red-50 overflow-hidden shadow-sm rounded-lg border border-red-200">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-red-700">{{ $statistik['ditolak'] }}</div>
                        <div class="text-sm text-red-600">Ditolak</div>
                    </div>
                </div>
            </div>

            <!-- Filter and Search -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🔍 Filter & Pencarian</h3>
                    <form method="GET" action="{{ route('admin.pengajuan-surat.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
                                <input type="text" name="jenis_surat" value="{{ request('jenis_surat') }}" 
                                       placeholder="Cari jenis surat..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama/NIK</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Cari nama atau NIK..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                🔍 Cari
                            </button>
                            <a href="{{ route('admin.pengajuan-surat.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                                🔄 Reset
                            </a>
                            <a href="{{ route('admin.pengajuan-surat.export', request()->query()) }}" 
                               class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                                📊 Export CSV
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Messages -->
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                ❌ {{ session('error') }}
            </div>
            @endif

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID/Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pemohon
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis Surat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengajuanList as $pengajuan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900">#{{ str_pad($pengajuan->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-gray-500">{{ $pengajuan->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-900">{{ $pengajuan->nama }}</div>
                                        <div class="text-gray-500">NIK: {{ $pengajuan->nik }}</div>
                                        @if($pengajuan->no_telepon)
                                        <div class="text-gray-500">📞 {{ $pengajuan->no_telepon }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $pengajuan->jenis_surat }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($pengajuan->keperluan, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '⏳'],
                                            'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '⚙️'],
                                            'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                            'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌']
                                        ];
                                        $currentStatus = $statusConfig[$pengajuan->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }}">
                                        {{ $currentStatus['icon'] }} {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.pengajuan-surat.show', $pengajuan) }}" 
                                           class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition">
                                            👁️ Detail
                                        </a>
                                        @if($pengajuan->status !== 'selesai')
                                        <button onclick="openQuickStatusModal({{ $pengajuan->id }}, '{{ $pengajuan->status }}')"
                                                class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded transition">
                                            ⚡ Status
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="text-6xl mb-4">📭</div>
                                    <div class="text-lg font-medium mb-2">Tidak ada pengajuan surat</div>
                                    <div class="text-sm">Belum ada pengajuan surat yang masuk atau sesuai filter yang dipilih.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pengajuanList->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pengajuanList->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ Ubah Status Cepat</h3>
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                            <select id="statusSelect" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending">⏳ Menunggu</option>
                                <option value="diproses">⚙️ Diproses</option>
                                <option value="selesai">✅ Selesai</option>
                                <option value="ditolak">❌ Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="catatan_admin" rows="3" 
                                      placeholder="Berikan catatan untuk pemohon..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeStatusModal()" 
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                💾 Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openQuickStatusModal(id, currentStatus) {
            document.getElementById('statusForm').action = `/admin/pengajuan-surat/${id}/status`;
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });
    </script>
</x-admin-layout> 