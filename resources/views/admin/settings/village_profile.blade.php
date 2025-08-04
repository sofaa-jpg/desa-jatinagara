<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏛️ {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                ✅ {{ session('success') }}
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

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.settings.update-village-profile') }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Data Kepala Desa -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                👤 Data Kepala Desa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['kepala_desa_nama'],
                                    'key' => 'kepala_desa_nama',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['kepala_desa_periode'],
                                    'key' => 'kepala_desa_periode',
                                    'errors' => $errors,
                                ])
                            </div>
                        </div>

                        <!-- Data Statistik Desa -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                📊 Data Statistik Desa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['tahun_berdiri'],
                                    'key' => 'tahun_berdiri',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['luas_wilayah'],
                                    'key' => 'luas_wilayah',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['jumlah_penduduk'],
                                    'key' => 'jumlah_penduduk',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['jumlah_kk'],
                                    'key' => 'jumlah_kk',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['kode_pos'],
                                    'key' => 'kode_pos',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['ketinggian'],
                                    'key' => 'ketinggian',
                                    'errors' => $errors,
                                ])
                            </div>
                        </div>

                        <!-- Batas Wilayah -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                🗺️ Batas Wilayah Desa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['batas_utara'],
                                    'key' => 'batas_utara',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['batas_selatan'],
                                    'key' => 'batas_selatan',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['batas_timur'],
                                    'key' => 'batas_timur',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['batas_barat'],
                                    'key' => 'batas_barat',
                                    'errors' => $errors,
                                ])
                            </div>
                        </div>

                        <!-- Motto Desa -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                ⭐ Identitas Desa
                            </h3>
                            @include('admin.settings.partials._setting_field', [
                                'setting' => $profileData['motto_desa'],
                                'key' => 'motto_desa',
                                'errors' => $errors,
                            ])
                        </div>

                        <!-- Media Sosial -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                📱 Media Sosial Desa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['social_facebook'],
                                    'key' => 'social_facebook',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['social_instagram'],
                                    'key' => 'social_instagram',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['social_twitter'],
                                    'key' => 'social_twitter',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['social_youtube'],
                                    'key' => 'social_youtube',
                                    'errors' => $errors,
                                ])
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                🕒 Jam Operasional Kantor Desa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['jam_operasional_senin_jumat'],
                                    'key' => 'jam_operasional_senin_jumat',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['jam_operasional_sabtu'],
                                    'key' => 'jam_operasional_sabtu',
                                    'errors' => $errors,
                                ])
                            </div>
                        </div>

                        <!-- Fasilitas Umum -->
                        <div class="pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                🏢 Fasilitas Umum Desa
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['fasilitas_pendidikan'],
                                    'key' => 'fasilitas_pendidikan',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['fasilitas_kesehatan'],
                                    'key' => 'fasilitas_kesehatan',
                                    'errors' => $errors,
                                ])
                                    
                                @include('admin.settings.partials._setting_field', [
                                    'setting' => $profileData['fasilitas_ibadah'],
                                    'key' => 'fasilitas_ibadah',
                                    'errors' => $errors,
                                ])
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                                💾 Simpan Data Profil Desa
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h4 class="font-semibold text-blue-800 mb-2">ℹ️ Informasi Penting:</h4>
                <ul class="text-blue-700 text-sm space-y-1">
                    <li>• Data ini akan ditampilkan di berbagai halaman website desa</li>
                    <li>• Media sosial akan tampil sebagai link di footer website</li>
                    <li>• Statistik desa akan digunakan untuk profil publik</li>
                    <li>• Pastikan semua data akurat dan up-to-date</li>
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout> 