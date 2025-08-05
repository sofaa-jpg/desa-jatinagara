<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Laporan Arsip Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Arsip Surat</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Generate dan export laporan surat berdasarkan filter</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.arsip-surat.statistik') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                📊 Statistik
                            </a>
                            <a href="{{ route('admin.arsip-surat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ← Beranda
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Filter Form -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Filter Laporan</h3>
            
            <form method="GET" action="{{ route('admin.arsip-surat.laporan') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                               value="{{ request('tanggal_mulai') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tanggal Selesai
                        </label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
                               value="{{ request('tanggal_selesai') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Jenis Surat -->
                    <div>
                        <label for="jenis_surat_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Jenis Surat
                        </label>
                        <select name="jenis_surat_id" id="jenis_surat_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                        <label for="sifat_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Sifat Surat
                        </label>
                        <select name="sifat_surat" id="sifat_surat" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Sifat</option>
                            <option value="Biasa" {{ request('sifat_surat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                            <option value="Penting" {{ request('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                            <option value="Segera" {{ request('sifat_surat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                            <option value="Rahasia" {{ request('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                        </select>
                    </div>

                    <!-- Tipe Surat -->
                    <div>
                        <label for="tipe_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Tipe Surat
                        </label>
                        <select name="tipe_surat" id="tipe_surat" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="semua" {{ request('tipe_surat', 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                            <option value="masuk" {{ request('tipe_surat') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                            <option value="keluar" {{ request('tipe_surat') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                        </select>
                    </div>

                    <!-- Status (untuk surat masuk) -->
                    <div id="status-masuk" style="display: {{ request('tipe_surat') == 'masuk' || request('tipe_surat') == 'semua' || !request('tipe_surat') ? 'block' : 'none' }}">
                        <label for="status_disposisi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Status Disposisi
                        </label>
                        <select name="status_disposisi" id="status_disposisi" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Belum" {{ request('status_disposisi') == 'Belum' ? 'selected' : '' }}>Belum</option>
                            <option value="Sudah" {{ request('status_disposisi') == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                            <option value="Selesai" {{ request('status_disposisi') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <!-- Status (untuk surat keluar) -->
                    <div id="status-keluar" style="display: {{ request('tipe_surat') == 'keluar' || request('tipe_surat') == 'semua' || !request('tipe_surat') ? 'block' : 'none' }}">
                        <label for="status_kirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Status Kirim
                        </label>
                        <select name="status_kirim" id="status_kirim" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Draft" {{ request('status_kirim') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Dikirim" {{ request('status_kirim') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Diterima" {{ request('status_kirim') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pencarian
                        </label>
                        <input type="text" name="search" id="search" 
                               value="{{ request('search') }}"
                               placeholder="Nomor surat, perihal..."
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex space-x-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            🔍 Filter Data
                        </button>
                        <a href="{{ route('admin.arsip-surat.laporan') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            🔄 Reset
                        </a>
                    </div>

                    @if($filteredData->count() > 0)
                        <div class="flex space-x-2 mt-3 md:mt-0">
                            <button onclick="exportData('excel')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                📊 Export Excel
                            </button>
                            <button onclick="exportData('pdf')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                📄 Export PDF
                            </button>
                            <button onclick="window.print()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                🖨️ Print
                            </button>
                        </div>
                    @endif
                </div>
            </form>
                    </div>

                    <!-- Summary Cards -->
                    @if($filteredData->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-5.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-5.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H1"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Surat Masuk</dt>
                                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $summary['masuk'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Surat Keluar</dt>
                                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $summary['keluar'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Surat</dt>
                                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $summary['total'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Dengan File</dt>
                                            <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $summary['berkas'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Data Table -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Hasil Laporan
                        @if($filteredData->count() > 0)
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                ({{ $filteredData->total() }} data ditemukan)
                            </span>
                        @endif
                    </h3>
                    
                    @if(request()->hasAny(['tanggal_mulai', 'tanggal_selesai', 'jenis_surat_id', 'sifat_surat', 'tipe_surat', 'status_disposisi', 'status_kirim', 'search']))
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Filter aktif:
                            @if(request('tanggal_mulai') || request('tanggal_selesai'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 mr-1">
                                    📅 {{ request('tanggal_mulai') }} - {{ request('tanggal_selesai') }}
                                </span>
                            @endif
                            @if(request('jenis_surat_id'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 mr-1">
                                    📝 {{ $jenisSurat->find(request('jenis_surat_id'))->nama_jenis ?? 'Unknown' }}
                                </span>
                            @endif
                            @if(request('sifat_surat'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 mr-1">
                                    ⚡ {{ request('sifat_surat') }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            @if($filteredData->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nomor & Perihal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jenis & Sifat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pengirim/Tujuan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider no-print">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($filteredData as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $filteredData->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($item->tipe === 'masuk')
                                                <div class="w-2 h-8 bg-blue-500 rounded"></div>
                                            @else
                                                <div class="w-2 h-8 bg-green-500 rounded"></div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $item->nomor_surat }}
                                                @if($item->file_surat)
                                                    <svg class="inline w-4 h-4 text-green-500 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ Str::limit($item->perihal, 40) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                        {{ $item->jenisSurat->kode_jenis }}
                                    </span>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $item->sifat_surat }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $item->tipe === 'masuk' ? $item->pengirim : $item->tujuan }}
                                    </div>
                                    @if($item->tipe === 'masuk' && $item->alamat_pengirim)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($item->alamat_pengirim, 30) }}
                                        </div>
                                    @elseif($item->tipe === 'keluar' && $item->alamat_tujuan)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($item->alamat_tujuan, 30) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $item->tipe === 'masuk' ? $item->tanggal_terima->format('d/m/Y') : $item->tanggal_surat->format('d/m/Y') }}
                                    </div>
                                    @if($item->tipe === 'keluar' && $item->tanggal_kirim)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Kirim: {{ $item->tanggal_kirim->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->tipe === 'masuk')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($item->status_disposisi === 'Belum') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @elseif($item->status_disposisi === 'Sudah') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                            @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">
                                            {{ $item->status_disposisi }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($item->status_kirim === 'Draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @elseif($item->status_kirim === 'Dikirim') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                            @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">
                                            {{ $item->status_kirim }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print">
                                    <div class="flex space-x-2">
                                        @if($item->tipe === 'masuk')
                                            <a href="{{ route('admin.surat-masuk.show', $item->id) }}" 
                                               class="text-blue-600 hover:text-blue-500 dark:text-blue-400" title="Lihat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.surat-keluar.show', $item->id) }}" 
                                               class="text-green-600 hover:text-green-500 dark:text-green-400" title="Lihat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        @if($item->file_surat)
                                            @if($item->tipe === 'masuk')
                                                <a href="{{ route('admin.surat-masuk.download', $item->id) }}" 
                                                   class="text-green-600 hover:text-green-500 dark:text-green-400" title="Download">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.surat-keluar.download', $item->id) }}" 
                                                   class="text-green-600 hover:text-green-500 dark:text-green-400" title="Download">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 no-print">
                    {{ $filteredData->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada data</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if(request()->hasAny(['tanggal_mulai', 'tanggal_selesai', 'jenis_surat_id', 'sifat_surat', 'tipe_surat', 'status_disposisi', 'status_kirim', 'search']))
                            Tidak ada data yang sesuai dengan filter yang dipilih.
                        @else
                            Silakan gunakan filter untuk mencari data yang diinginkan.
                        @endif
                    </p>
                </div>
            @endif
                    </div>

                    <!-- Footer Info -->
                    @if($filteredData->count() > 0)
                        <div class="mt-6 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 text-sm text-gray-600 dark:text-gray-400 no-print">
                            <div class="flex items-center justify-between">
                                <div>
                                    <strong>Keterangan:</strong>
                                    <span class="inline-block w-3 h-3 bg-blue-500 rounded mr-1 ml-2"></span> Surat Masuk
                                    <span class="inline-block w-3 h-3 bg-green-500 rounded mr-1 ml-2"></span> Surat Keluar
                                    <svg class="inline w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z"></path>
                                    </svg> Ada file lampiran
                                </div>
                                <div>
                                    Laporan dibuat pada: {{ now()->format('d F Y H:i') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
// Toggle status fields based on tipe surat
document.getElementById('tipe_surat').addEventListener('change', function() {
    const statusMasuk = document.getElementById('status-masuk');
    const statusKeluar = document.getElementById('status-keluar');
    
    if (this.value === 'masuk') {
        statusMasuk.style.display = 'block';
        statusKeluar.style.display = 'none';
    } else if (this.value === 'keluar') {
        statusMasuk.style.display = 'none';
        statusKeluar.style.display = 'block';
    } else {
        statusMasuk.style.display = 'block';
        statusKeluar.style.display = 'block';
    }
});

// Export functions
function exportData(format) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.arsip-surat.export-laporan") }}';
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    // Add format
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'format';
    formatInput.value = format;
    form.appendChild(formatInput);
    
    // Add all current filter parameters
    const params = new URLSearchParams(window.location.search);
    params.forEach((value, key) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Quick date filters
function setDateFilter(days) {
    const today = new Date();
    const startDate = new Date(today);
    startDate.setDate(today.getDate() - days);
    
    document.getElementById('tanggal_selesai').value = today.toISOString().split('T')[0];
    document.getElementById('tanggal_mulai').value = startDate.toISOString().split('T')[0];
}

// Auto-submit form when filter changes (optional)
// document.querySelectorAll('select, input[type="date"]').forEach(element => {
//     element.addEventListener('change', function() {
//         // Auto-submit form after a delay
//         // setTimeout(() => this.form.submit(), 500);
//     });
// });
</script>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .bg-gray-50, .bg-gray-100, .bg-gray-800, .bg-gray-900 { background: white !important; }
    .text-gray-900, .text-gray-800, .text-white { color: black !important; }
    .border-gray-200, .border-gray-300, .border-gray-700 { border-color: #ddd !important; }
    table { page-break-inside: auto; }
    tr { page-break-inside: avoid; page-break-after: auto; }
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }
}
</style>
@endpush

</x-admin-layout>