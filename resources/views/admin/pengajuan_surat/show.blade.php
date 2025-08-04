<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Detail Pengajuan Surat #{{ str_pad($pengajuanSurat->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
            <a href="{{ route('admin.pengajuan-surat.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <strong>Terdapat kesalahan:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Data Pengajuan -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📄 Informasi Pengajuan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nomor Pengajuan</label>
                                    <div class="mt-1 text-lg font-bold text-blue-600">#{{ str_pad($pengajuanSurat->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Tanggal Pengajuan</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $pengajuanSurat->created_at->format('d F Y, H:i') }} WIB</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Jenis Surat</label>
                                    <div class="mt-1 text-sm font-medium text-gray-900">{{ $pengajuanSurat->jenis_surat }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status Saat Ini</label>
                                    <div class="mt-1">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '⏳', 'label' => 'Menunggu Diproses'],
                                                'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '⚙️', 'label' => 'Sedang Diproses'],
                                                'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅', 'label' => 'Selesai'],
                                                'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌', 'label' => 'Ditolak']
                                            ];
                                            $currentStatus = $statusConfig[$pengajuanSurat->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }}">
                                            {{ $currentStatus['icon'] }} {{ $currentStatus['label'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pemohon -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">👤 Data Pemohon</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $pengajuanSurat->nama }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">NIK</label>
                                    <div class="mt-1 text-sm text-gray-900 font-mono">{{ $pengajuanSurat->nik }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        @if($pengajuanSurat->no_telepon)
                                            <a href="tel:{{ $pengajuanSurat->no_telepon }}" class="text-blue-600 hover:underline">
                                                📞 {{ $pengajuanSurat->no_telepon }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Tidak tersedia</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Email</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        @if($pengajuanSurat->email)
                                            <a href="mailto:{{ $pengajuanSurat->email }}" class="text-blue-600 hover:underline">
                                                ✉️ {{ $pengajuanSurat->email }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Tidak tersedia</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-600">Alamat</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        @if($pengajuanSurat->alamat)
                                            {{ $pengajuanSurat->alamat }}
                                        @else
                                            <span class="text-gray-400">Tidak tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📝 Keperluan/Tujuan Penggunaan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $pengajuanSurat->keperluan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Admin -->
                    @if($pengajuanSurat->catatan_admin)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">💬 Catatan Admin</h3>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm text-blue-700 whitespace-pre-line">{{ $pengajuanSurat->catatan_admin }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Actions -->
                <div class="space-y-6">
                    <!-- Status Management -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">⚙️ Kelola Status</h3>
                            <form method="POST" action="{{ route('admin.pengajuan-surat.update-status', $pengajuanSurat) }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status</label>
                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="pending" {{ $pengajuanSurat->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Diproses</option>
                                        <option value="diproses" {{ $pengajuanSurat->status === 'diproses' ? 'selected' : '' }}>⚙️ Sedang Diproses</option>
                                        <option value="selesai" {{ $pengajuanSurat->status === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                        <option value="ditolak" {{ $pengajuanSurat->status === 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan untuk Pemohon</label>
                                    <textarea name="catatan_admin" rows="4" 
                                              placeholder="Berikan catatan atau keterangan tambahan..."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $pengajuanSurat->catatan_admin }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Catatan ini akan terlihat oleh pemohon saat mengecek status</p>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                                    💾 Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">🚀 Aksi Cepat</h3>
                            <div class="space-y-3">
                                @if($pengajuanSurat->no_telepon)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengajuanSurat->no_telepon) }}" 
                                   target="_blank" 
                                   class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-200 text-center block">
                                    💬 Chat WhatsApp
                                </a>
                                @endif
                                
                                @if($pengajuanSurat->email)
                                <a href="mailto:{{ $pengajuanSurat->email }}?subject=Pengajuan Surat {{ $pengajuanSurat->jenis_surat }}" 
                                   class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 text-center block">
                                    ✉️ Kirim Email
                                </a>
                                @endif

                                @if($pengajuanSurat->status === 'selesai')
                                <a href="{{ route('admin.letter-generator.create') }}" 
                                   class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition duration-200 text-center block">
                                    📄 Generate Surat
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-red-200">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-red-600 mb-4">⚠️ Zona Bahaya</h3>
                            <form method="POST" action="{{ route('admin.pengajuan-surat.destroy', $pengajuanSurat) }}" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini? Tindakan ini tidak dapat dibatalkan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition duration-200">
                                    🗑️ Hapus Pengajuan
                                </button>
                            </form>
                            <p class="text-xs text-red-500 mt-2">Tindakan ini akan menghapus permanen data pengajuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 