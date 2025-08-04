<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Pengajuan Surat') }}
        </h2>
    </x-slot>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary/10 to-secondary/10 pt-24 pb-8">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-3xl lg:text-4xl font-bold text-primary mb-4">
                📋 Status Pengajuan Surat
            </h1>
            <p class="text-lg text-secondary-dark mb-6">
                Lacak perkembangan pengajuan surat Anda secara real-time
            </p>
            <nav class="text-sm">
                <a href="{{ route('online-services') }}" class="text-primary hover:underline">Layanan Online</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-600">Status Pengajuan</span>
            </nav>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            
            @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex">
                    <div class="text-green-400 mr-3">✅</div>
                    <div>
                        <h3 class="text-green-800 font-semibold mb-2">Berhasil!</h3>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex">
                    <div class="text-red-400 mr-3">❌</div>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-2">Kesalahan!</h3>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex">
                    <div class="text-red-400 mr-3">❌</div>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-2">Terdapat kesalahan:</h3>
                        <ul class="text-red-700 list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Search Form -->
            @if(!isset($pengajuan) && !isset($pengajuanList))
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
                <h2 class="text-2xl font-bold text-primary mb-6 text-center">🔍 Cari Pengajuan Anda</h2>
                
                <form method="POST" action="{{ route('online-services.status') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Pencarian</label>
                            <select name="search_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" required>
                                <option value="">-- Pilih Jenis Pencarian --</option>
                                <option value="id" {{ old('search_type') === 'id' ? 'selected' : '' }}>Nomor Pengajuan (ID)</option>
                                <option value="nik" {{ old('search_type') === 'nik' ? 'selected' : '' }}>NIK (Nomor Induk Kependudukan)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Nomor/NIK</label>
                            <input type="text" name="search_value" value="{{ old('search_value') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary" 
                                   placeholder="Contoh: 000123 atau 1234567890123456" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" 
                                class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                            🔍 Cari Status Pengajuan
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Single Result -->
            @if(isset($pengajuan))
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-2">Detail Pengajuan</h2>
                    <p class="text-gray-600">Nomor Pengajuan: <span class="font-bold text-primary">#{{ str_pad($pengajuan->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Data Pengajuan -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">📄 Data Pengajuan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-medium">{{ $pengajuan->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">NIK:</span>
                                <span class="font-medium">{{ $pengajuan->nik }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Surat:</span>
                                <span class="font-medium">{{ $pengajuan->jenis_surat }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pengajuan:</span>
                                <span class="font-medium">{{ $pengajuan->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Timeline -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">📊 Status Pengajuan</h3>
                        
                        <!-- Status Badge -->
                        <div class="text-center">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '⏳', 'label' => 'Menunggu Diproses'],
                                    'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '⚙️', 'label' => 'Sedang Diproses'],
                                    'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅', 'label' => 'Selesai'],
                                    'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌', 'label' => 'Ditolak']
                                ];
                                $currentStatus = $statusConfig[$pengajuan->status] ?? $statusConfig['pending'];
                            @endphp
                            
                            <div class="inline-flex items-center px-6 py-3 rounded-full {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} font-semibold text-lg">
                                <span class="mr-2">{{ $currentStatus['icon'] }}</span>
                                {{ $currentStatus['label'] }}
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mt-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                                    <div>
                                        <p class="font-medium text-gray-800">Pengajuan Diterima</p>
                                        <p class="text-sm text-gray-600">{{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                @if($pengajuan->status !== 'pending')
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                                    <div>
                                        <p class="font-medium text-gray-800">Sedang Diproses</p>
                                        <p class="text-sm text-gray-600">{{ $pengajuan->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if($pengajuan->status === 'selesai')
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                                    <div>
                                        <p class="font-medium text-gray-800">Selesai</p>
                                        <p class="text-sm text-gray-600">{{ $pengajuan->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keperluan -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">📝 Keperluan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $pengajuan->keperluan }}</p>
                    </div>
                </div>

                @if($pengajuan->catatan_admin)
                <div class="mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">💬 Catatan Admin</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-blue-700">{{ $pengajuan->catatan_admin }}</p>
                    </div>
                </div>
                @endif

                <div class="mt-8 text-center border-t pt-6">
                    <a href="{{ route('online-services') }}" 
                       class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition mr-4">
                        ← Kembali ke Layanan Online
                    </a>
                    <a href="{{ route('online-services.status') }}" 
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition">
                        🔍 Cari Pengajuan Lain
                    </a>
                </div>
            </div>
            @endif

            <!-- Multiple Results -->
            @if(isset($pengajuanList))
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-primary mb-2">Hasil Pencarian</h2>
                    <p class="text-gray-600">Ditemukan {{ $pengajuanList->count() }} pengajuan</p>
                </div>

                @if($pengajuanList->count() > 0)
                <div class="space-y-4">
                    @foreach($pengajuanList as $item)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="text-sm text-gray-500 mr-3">#{!! str_pad($item->id, 6, '0', STR_PAD_LEFT) !!}</span>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '⏳'],
                                            'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '⚙️'],
                                            'selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '✅'],
                                            'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '❌']
                                        ];
                                        $currentStatus = $statusConfig[$item->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} font-medium">
                                        {{ $currentStatus['icon'] }} {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                                <h3 class="font-semibold text-gray-800 mb-1">{{ $item->jenis_surat }}</h3>
                                <p class="text-gray-600 text-sm">Diajukan: {{ $item->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="mt-4 lg:mt-0">
                                <a href="{{ route('online-services.status', $item->id) }}" 
                                   class="inline-block bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Tidak ada pengajuan yang ditemukan dengan kriteria pencarian tersebut.</p>
                    <a href="{{ route('online-services.status') }}" 
                       class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                        🔍 Coba Cari Lagi
                    </a>
                </div>
                @endif

                <div class="mt-8 text-center border-t pt-6">
                    <a href="{{ route('online-services') }}" 
                       class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition mr-4">
                        ← Kembali ke Layanan Online
                    </a>
                    <a href="{{ route('online-services.status') }}" 
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition">
                        🔍 Cari Lagi
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
</x-app-layout> 