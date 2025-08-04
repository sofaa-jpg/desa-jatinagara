<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Informasi & Statistik Desa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                // Ambil data profil desa
                $kepalaDesa = App\Models\ProfileContent::where('key', 'kepala_desa_nama')->first();
                $periodeKades = App\Models\ProfileContent::where('key', 'kepala_desa_periode')->first();
                $tahunBerdiri = App\Models\ProfileContent::where('key', 'tahun_berdiri')->first();
                $luasWilayah = App\Models\ProfileContent::where('key', 'luas_wilayah')->first();
                $jumlahPenduduk = App\Models\ProfileContent::where('key', 'jumlah_penduduk')->first();
                $jumlahKK = App\Models\ProfileContent::where('key', 'jumlah_kk')->first();
                $kodePos = App\Models\ProfileContent::where('key', 'kode_pos')->first();
                $ketinggian = App\Models\ProfileContent::where('key', 'ketinggian')->first();
                $motto = App\Models\ProfileContent::where('key', 'motto_desa')->first();
                
                // Batas wilayah
                $batasUtara = App\Models\ProfileContent::where('key', 'batas_utara')->first();
                $batasSelatan = App\Models\ProfileContent::where('key', 'batas_selatan')->first();
                $batasTimur = App\Models\ProfileContent::where('key', 'batas_timur')->first();
                $batasBarat = App\Models\ProfileContent::where('key', 'batas_barat')->first();
                
                // Fasilitas
                $fasilitasPendidikan = App\Models\ProfileContent::where('key', 'fasilitas_pendidikan')->first();
                $fasilitasKesehatan = App\Models\ProfileContent::where('key', 'fasilitas_kesehatan')->first();
                $fasilitasIbadah = App\Models\ProfileContent::where('key', 'fasilitas_ibadah')->first();
                
                // Jam operasional
                $jamSeninJumat = App\Models\ProfileContent::where('key', 'jam_operasional_senin_jumat')->first();
                $jamSabtu = App\Models\ProfileContent::where('key', 'jam_operasional_sabtu')->first();
            @endphp

            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-primary/10 to-secondary/10 rounded-2xl p-8 mb-8">
                <div class="text-center">
                    <h1 class="text-3xl lg:text-4xl font-bold text-primary mb-4">
                        {{ $villageName->content ?? 'Nama Desa' }}
                    </h1>
                    @if($motto && $motto->content)
                    <p class="text-lg text-gray-700 italic font-medium">
                        "{{ $motto->content }}"
                    </p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Data Pemerintahan -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Kepala Desa -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                👤 Kepala Desa
                            </h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="text-lg font-semibold text-blue-800">
                                    {{ $kepalaDesa->content ?? 'Belum diatur' }}
                                </div>
                                @if($periodeKades && $periodeKades->content)
                                <div class="text-sm text-blue-600 mt-1">
                                    Periode: {{ $periodeKades->content }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Desa -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                📊 Statistik Desa
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="bg-green-50 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $tahunBerdiri->content ?? '-' }}
                                    </div>
                                    <div class="text-sm text-green-700">Tahun Berdiri</div>
                                </div>
                                
                                <div class="bg-blue-50 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ $luasWilayah->content ?? '-' }}
                                    </div>
                                    <div class="text-sm text-blue-700">Luas Wilayah</div>
                                </div>
                                
                                <div class="bg-purple-50 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-purple-600">
                                        {{ $jumlahPenduduk->content ?? '-' }}
                                    </div>
                                    <div class="text-sm text-purple-700">Jumlah Penduduk</div>
                                </div>
                                
                                <div class="bg-orange-50 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-orange-600">
                                        {{ $jumlahKK->content ?? '-' }}
                                    </div>
                                    <div class="text-sm text-orange-700">Jumlah KK</div>
                                </div>
                                
                                <div class="bg-red-50 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-red-600">
                                        {{ $ketinggian->content ?? '-' }}
                                    </div>
                                    <div class="text-sm text-red-700">Ketinggian</div>
                                </div>
                                
                                <div class="bg-teal-50 p-4 rounded-lg text-center">
                                    <div class="text-2xl font-bold text-teal-600">
                                        {{ $kodePos->content ?? '-' }}
                                    </div>
                                    <div class="text-sm text-teal-700">Kode Pos</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Batas Wilayah -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                🗺️ Batas Wilayah
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="font-semibold text-gray-700 mb-1">Utara</div>
                                    <div class="text-gray-600">{{ $batasUtara->content ?? 'Belum diatur' }}</div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="font-semibold text-gray-700 mb-1">Selatan</div>
                                    <div class="text-gray-600">{{ $batasSelatan->content ?? 'Belum diatur' }}</div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="font-semibold text-gray-700 mb-1">Timur</div>
                                    <div class="text-gray-600">{{ $batasTimur->content ?? 'Belum diatur' }}</div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="font-semibold text-gray-700 mb-1">Barat</div>
                                    <div class="text-gray-600">{{ $batasBarat->content ?? 'Belum diatur' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-6">
                    <!-- Jam Operasional -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                🕒 Jam Operasional
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Senin - Jumat</span>
                                    <span class="font-medium text-gray-800">
                                        {{ $jamSeninJumat->content ?? 'Belum diatur' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Sabtu</span>
                                    <span class="font-medium text-gray-800">
                                        {{ $jamSabtu->content ?? 'Belum diatur' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Minggu</span>
                                    <span class="font-medium text-red-600">Tutup</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fasilitas Umum -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                🏢 Fasilitas Umum
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="font-medium text-gray-700 mb-1">📚 Pendidikan</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $fasilitasPendidikan->content ?? 'Belum diatur' }}
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="font-medium text-gray-700 mb-1">🏥 Kesehatan</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $fasilitasKesehatan->content ?? 'Belum diatur' }}
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="font-medium text-gray-700 mb-1">🕌 Ibadah</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $fasilitasIbadah->content ?? 'Belum diatur' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">🔗 Tautan Terkait</h3>
                            <div class="space-y-2">
                                <a href="{{ route('profil.visi') }}" 
                                   class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg text-blue-700 font-medium transition">
                                    Visi & Misi Desa
                                </a>
                                <a href="{{ route('profil.sejarah') }}" 
                                   class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg text-green-700 font-medium transition">
                                    Sejarah Desa
                                </a>
                                <a href="{{ route('profil.struktur') }}" 
                                   class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg text-purple-700 font-medium transition">
                                    Struktur Pemerintahan
                                </a>
                                <a href="{{ route('institutions.index') }}" 
                                   class="block p-3 bg-orange-50 hover:bg-orange-100 rounded-lg text-orange-700 font-medium transition">
                                    Lembaga Desa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 