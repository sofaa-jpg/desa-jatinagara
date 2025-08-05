<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Arsip Surat Desa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    
                    <!-- Header Dashboard -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Dashboard Arsip Surat</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1 transition-colors">Kelola dan pantau surat masuk & keluar desa</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.surat-masuk.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                + Tambah Surat Masuk
                            </a>
                            <a href="{{ route('admin.surat-keluar.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                + Tambah Surat Keluar
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Statistik Cards -->
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 transition-colors">Statistik Umum</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Surat Masuk -->
                        <div class="bg-blue-600 dark:bg-blue-700 text-white p-6 rounded-lg shadow-lg flex items-center justify-between transition-transform transform hover:scale-105 duration-200">
                            <div>
                                <div class="text-3xl font-bold">{{ $totalSuratMasuk }}</div>
                                <div class="text-sm opacity-90">Total Surat Masuk</div>
                            </div>
                            <svg class="h-10 w-10 opacity-75" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-5.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-5.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H1"></path>
                            </svg>
                        </div>

                        <!-- Total Surat Keluar -->
                        <div class="bg-green-600 dark:bg-green-700 text-white p-6 rounded-lg shadow-lg flex items-center justify-between transition-transform transform hover:scale-105 duration-200">
                            <div>
                                <div class="text-3xl font-bold">{{ $totalSuratKeluar }}</div>
                                <div class="text-sm opacity-90">Total Surat Keluar</div>
                            </div>
                            <svg class="h-10 w-10 opacity-75" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>

                        <!-- Surat Masuk Bulan Ini -->
                        <div class="bg-purple-600 dark:bg-purple-700 text-white p-6 rounded-lg shadow-lg flex items-center justify-between transition-transform transform hover:scale-105 duration-200">
                            <div>
                                <div class="text-3xl font-bold">{{ $suratMasukBulanIni }}</div>
                                <div class="text-sm opacity-90">Masuk Bulan Ini</div>
                            </div>
                            <svg class="h-10 w-10 opacity-75" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M12 12h.01m4 0h.01m-7 4h.01m4 0h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <!-- Surat Keluar Bulan Ini -->
                        <div class="bg-yellow-600 dark:bg-yellow-700 text-white p-6 rounded-lg shadow-lg flex items-center justify-between transition-transform transform hover:scale-105 duration-200">
                            <div>
                                <div class="text-3xl font-bold">{{ $suratKeluarBulanIni }}</div>
                                <div class="text-sm opacity-90">Keluar Bulan Ini</div>
                            </div>
                            <svg class="h-10 w-10 opacity-75" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M12 12h.01m4 0h.01m-7 4h.01m4 0h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Surat Terbaru -->
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 mt-8 transition-colors">Aktivitas & Data Terbaru</h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Surat Masuk Terbaru -->
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3 transition-colors">Surat Masuk Terbaru</h5>
                            <ul class="space-y-3">
                                @forelse($suratMasukTerbaru as $surat)
                                    <li class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm flex items-center justify-between transition-colors duration-200">
                                        <div>
                                            <a href="{{ route('admin.surat-masuk.show', $surat) }}" class="text-gray-800 dark:text-gray-100 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                {{ $surat->nomor_surat }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ Str::limit($surat->perihal, 40) }} - {{ $surat->pengirim }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $surat->tanggal_terima->format('d M Y') }}
                                            </p>
                                        </div>
                                        @php
                                            $statusClass = [
                                                'Belum' => 'bg-yellow-500',
                                                'Sudah' => 'bg-blue-500', 
                                                'Selesai' => 'bg-green-500'
                                            ][$surat->status_disposisi] ?? 'bg-gray-500';
                                        @endphp
                                        <span class="px-2.5 py-0.5 {{ $statusClass }} text-white text-xs font-medium rounded-full">
                                            {{ $surat->status_disposisi }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-500 dark:text-gray-400 text-sm transition-colors">
                                        Tidak ada surat masuk terbaru.
                                    </li>
                                @endforelse
                            </ul>
                            @if($suratMasukTerbaru->count() > 0)
                                <div class="text-right mt-4">
                                    <a href="{{ route('admin.surat-masuk.index') }}" class="text-blue-600 dark:text-blue-400 text-sm hover:underline transition-colors">
                                        Lihat Semua Surat Masuk &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Surat Keluar Terbaru -->
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3 transition-colors">Surat Keluar Terbaru</h5>
                            <ul class="space-y-3">
                                @forelse($suratKeluarTerbaru as $surat)
                                    <li class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm flex items-center justify-between transition-colors duration-200">
                                        <div>
                                            <a href="{{ route('admin.surat-keluar.show', $surat) }}" class="text-gray-800 dark:text-gray-100 font-medium hover:text-green-600 dark:hover:text-green-400 transition-colors">
                                                {{ $surat->nomor_surat }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ Str::limit($surat->perihal, 40) }} - {{ $surat->tujuan }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $surat->tanggal_surat->format('d M Y') }}
                                            </p>
                                        </div>
                                        @php
                                            $statusClass = [
                                                'Draft' => 'bg-gray-500',
                                                'Dikirim' => 'bg-blue-500',
                                                'Diterima' => 'bg-green-500'
                                            ][$surat->status_kirim] ?? 'bg-gray-500';
                                        @endphp
                                        <span class="px-2.5 py-0.5 {{ $statusClass }} text-white text-xs font-medium rounded-full">
                                            {{ $surat->status_kirim }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-500 dark:text-gray-400 text-sm transition-colors">
                                        Tidak ada surat keluar terbaru.
                                    </li>
                                @endforelse
                            </ul>
                            @if($suratKeluarTerbaru->count() > 0)
                                <div class="text-right mt-4">
                                    <a href="{{ route('admin.surat-keluar.index') }}" class="text-green-600 dark:text-green-400 text-sm hover:underline transition-colors">
                                        Lihat Semua Surat Keluar &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Quick Actions -->
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 transition-colors">Aksi Cepat</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <a href="{{ route('admin.surat-masuk.index') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-5.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-5.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H1"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Kelola Surat Masuk</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.surat-keluar.index') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Kelola Surat Keluar</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.arsip-surat.statistik') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Lihat Statistik</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.arsip-surat.laporan') }}" class="flex items-center p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Buat Laporan</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>