<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight transition-colors">
            {{ __('Statistik Arsip Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Statistik Arsip Surat</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Grafik dan analisis data surat masuk & keluar</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.arsip-surat.laporan') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                📊 Laporan
                            </a>
                            <a href="{{ route('admin.arsip-surat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                ← Beranda
                            </a>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8 transition-colors">

                    <!-- Filter Controls -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Filter Data</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="filterTahun" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                                <select id="filterTahun" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="filterJenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Surat</label>
                                <select id="filterJenis" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisSurat as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filterSifat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sifat Surat</label>
                                <select id="filterSifat" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Sifat</option>
                                    <option value="Biasa">Biasa</option>
                                    <option value="Penting">Penting</option>
                                    <option value="Segera">Segera</option>
                                    <option value="Rahasia">Rahasia</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button onclick="updateCharts()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    🔄 Update Grafik
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-5.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-5.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H1"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-blue-100 truncate">Total Surat Masuk</dt>
                                        <dd class="text-lg font-medium" id="totalMasuk">{{ $totalSuratMasuk }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-green-100 truncate">Total Surat Keluar</dt>
                                        <dd class="text-lg font-medium" id="totalKeluar">{{ $totalSuratKeluar }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-purple-100 truncate">Total Semua Surat</dt>
                                        <dd class="text-lg font-medium" id="totalSemua">{{ $totalSuratMasuk + $totalSuratKeluar }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-lg text-white">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-yellow-100 truncate">Bulan Ini</dt>
                                        <dd class="text-lg font-medium" id="totalBulanIni">{{ $suratBulanIni }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Chart Bulanan -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Grafik Surat Per Bulan</h3>
                    <div class="flex space-x-2">
                        <button onclick="toggleChartType('bulanan')" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm">
                            📊 Toggle
                        </button>
                    </div>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="chartBulanan"></canvas>
                </div>
            </div>

            <!-- Chart Jenis Surat -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Distribusi Jenis Surat</h3>
                    <div class="flex space-x-2">
                        <button onclick="toggleChartType('jenis')" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm">
                            🥧 Toggle
                        </button>
                    </div>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="chartJenis"></canvas>
                </div>
            </div>
                    </div>

                    <!-- More Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Chart Sifat Surat -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Distribusi Sifat Surat</h3>
                    <div class="flex space-x-2">
                        <button onclick="toggleChartType('sifat')" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm">
                            📈 Toggle
                        </button>
                    </div>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="chartSifat"></canvas>
                </div>
            </div>

            <!-- Chart Status -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Status Disposisi & Pengiriman</h3>
                    <div class="flex space-x-2">
                        <button onclick="toggleChartType('status')" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 text-sm">
                            📊 Toggle
                        </button>
                    </div>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
                    </div>

                    <!-- Trend Analysis -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Trend Tahunan</h3>
            <div class="relative" style="height: 400px;">
                <canvas id="chartTrend"></canvas>
            </div>
                    </div>

                    <!-- Detailed Statistics Tables -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Jenis Surat -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 5 Jenis Surat</h3>
                <div class="space-y-3">
                    @foreach($topJenisSurat as $index => $jenis)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-medium rounded-full mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $jenis->nama_jenis }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $jenis->kode_jenis }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $jenis->total_count }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">total surat</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ringkasan 6 Bulan Terakhir</h3>
                <div class="space-y-3">
                    @foreach($monthlyStats as $month => $stats)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $month }}</p>
                            </div>
                            <div class="flex space-x-4 text-right">
                                <div>
                                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $stats['masuk'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Masuk</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-600 dark:text-green-400">{{ $stats['keluar'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Keluar</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
                    </div>

                    <!-- Export & Print Actions -->
                    <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Aksi Export</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="printCharts()" class="flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Grafik
                </button>
                <button onclick="downloadChartImages()" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Gambar
                </button>
                <a href="{{ route('admin.arsip-surat.laporan') }}" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Buat Laporan
                </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
// Chart variables
let chartBulanan, chartJenis, chartSifat, chartStatus, chartTrend;
let chartTypes = {
    bulanan: 'line',
    jenis: 'doughnut',
    sifat: 'bar',
    status: 'bar'
};

// Chart data from PHP
const chartData = {
    bulanan: @json($chartBulanan),
    jenisSurat: @json($chartJenisSurat),
    sifatSurat: @json($chartSifatSurat),
    statusSurat: @json($chartStatusSurat),
    trendTahunan: @json($chartTrendTahunan)
};

// Chart colors
const colors = {
    primary: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#F97316', '#06B6D4', '#84CC16'],
    gradient: {
        blue: {
            start: 'rgba(59, 130, 246, 0.8)',
            end: 'rgba(59, 130, 246, 0.1)'
        },
        green: {
            start: 'rgba(16, 185, 129, 0.8)',
            end: 'rgba(16, 185, 129, 0.1)'
        }
    }
};

// Initialize charts on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Chart Bulanan
    const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
    chartBulanan = new Chart(ctxBulanan, {
        type: chartTypes.bulanan,
        data: {
            labels: chartData.bulanan.labels,
            datasets: [{
                label: 'Surat Masuk',
                data: chartData.bulanan.masuk,
                borderColor: colors.primary[0],
                backgroundColor: colors.gradient.blue.start,
                fill: false,
                tension: 0.1
            }, {
                label: 'Surat Keluar',
                data: chartData.bulanan.keluar,
                borderColor: colors.primary[1],
                backgroundColor: colors.gradient.green.start,
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });

    // Chart Jenis Surat
    const ctxJenis = document.getElementById('chartJenis').getContext('2d');
    chartJenis = new Chart(ctxJenis, {
        type: chartTypes.jenis,
        data: {
            labels: chartData.jenisSurat.labels,
            datasets: [{
                data: chartData.jenisSurat.data,
                backgroundColor: colors.primary.slice(0, chartData.jenisSurat.labels.length),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' surat';
                        }
                    }
                }
            }
        }
    });

    // Chart Sifat Surat
    const ctxSifat = document.getElementById('chartSifat').getContext('2d');
    chartSifat = new Chart(ctxSifat, {
        type: chartTypes.sifat,
        data: {
            labels: chartData.sifatSurat.labels,
            datasets: [{
                label: 'Jumlah Surat',
                data: chartData.sifatSurat.data,
                backgroundColor: [
                    colors.primary[2], // Biasa - Yellow
                    colors.primary[3], // Penting - Red
                    colors.primary[0], // Segera - Blue
                    colors.primary[4]  // Rahasia - Purple
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Chart Status
    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    chartStatus = new Chart(ctxStatus, {
        type: chartTypes.status,
        data: {
            labels: chartData.statusSurat.labels,
            datasets: [{
                label: 'Status Disposisi',
                data: chartData.statusSurat.disposisi,
                backgroundColor: colors.primary[0],
                borderWidth: 1
            }, {
                label: 'Status Pengiriman',
                data: chartData.statusSurat.pengiriman,
                backgroundColor: colors.primary[1],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Chart Trend Tahunan
    const ctxTrend = document.getElementById('chartTrend').getContext('2d');
    chartTrend = new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: chartData.trendTahunan.labels,
            datasets: [{
                label: 'Surat Masuk',
                data: chartData.trendTahunan.masuk,
                borderColor: colors.primary[0],
                backgroundColor: colors.gradient.blue.start,
                fill: true,
                tension: 0.3
            }, {
                label: 'Surat Keluar',
                data: chartData.trendTahunan.keluar,
                borderColor: colors.primary[1],
                backgroundColor: colors.gradient.green.start,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
}

function toggleChartType(chartName) {
    const chartMap = {
        bulanan: chartBulanan,
        jenis: chartJenis,
        sifat: chartSifat,
        status: chartStatus
    };

    const chart = chartMap[chartName];
    if (!chart) return;

    // Toggle between different chart types
    const newType = chart.config.type === 'line' ? 'bar' : 
                   chart.config.type === 'bar' ? 'doughnut' :
                   chart.config.type === 'doughnut' ? 'line' : 'line';

    chart.config.type = newType;
    chart.update();
}

function updateCharts() {
    const tahun = document.getElementById('filterTahun').value;
    const jenis = document.getElementById('filterJenis').value;
    const sifat = document.getElementById('filterSifat').value;

    // Show loading state
    const buttons = document.querySelectorAll('button');
    buttons.forEach(btn => btn.disabled = true);

    // Make AJAX request to get filtered data
    fetch(`{{ route('admin.arsip-surat.statistik') }}?tahun=${tahun}&jenis=${jenis}&sifat=${sifat}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update chart data
        updateChartData(data);
        
        // Update summary cards
        updateSummaryCards(data.summary);
        
        // Re-enable buttons
        buttons.forEach(btn => btn.disabled = false);
    })
    .catch(error => {
        console.error('Error updating charts:', error);
        buttons.forEach(btn => btn.disabled = false);
    });
}

function updateChartData(data) {
    // Update all charts with new data
    if (chartBulanan && data.bulanan) {
        chartBulanan.data.datasets[0].data = data.bulanan.masuk;
        chartBulanan.data.datasets[1].data = data.bulanan.keluar;
        chartBulanan.update();
    }

    if (chartJenis && data.jenisSurat) {
        chartJenis.data.labels = data.jenisSurat.labels;
        chartJenis.data.datasets[0].data = data.jenisSurat.data;
        chartJenis.update();
    }

    if (chartSifat && data.sifatSurat) {
        chartSifat.data.datasets[0].data = data.sifatSurat.data;
        chartSifat.update();
    }

    if (chartStatus && data.statusSurat) {
        chartStatus.data.datasets[0].data = data.statusSurat.disposisi;
        chartStatus.data.datasets[1].data = data.statusSurat.pengiriman;
        chartStatus.update();
    }
}

function updateSummaryCards(summary) {
    document.getElementById('totalMasuk').textContent = summary.totalMasuk;
    document.getElementById('totalKeluar').textContent = summary.totalKeluar;
    document.getElementById('totalSemua').textContent = summary.totalSemua;
    document.getElementById('totalBulanIni').textContent = summary.bulanIni;
}

function printCharts() {
    window.print();
}

function downloadChartImages() {
    const charts = [chartBulanan, chartJenis, chartSifat, chartStatus, chartTrend];
    const names = ['bulanan', 'jenis', 'sifat', 'status', 'trend'];
    
    charts.forEach((chart, index) => {
        if (chart) {
            const url = chart.toBase64Image();
            const link = document.createElement('a');
            link.download = `chart-${names[index]}.png`;
            link.href = url;
            link.click();
        }
    });
}

// Print styles for charts
const printStyles = `
@media print {
    .no-print { display: none !important; }
    .chart-container { page-break-inside: avoid; }
    canvas { max-width: 100% !important; height: auto !important; }
}
`;

// Add print styles to head
const styleSheet = document.createElement('style');
styleSheet.textContent = printStyles;
document.head.appendChild(styleSheet);
</script>
@endpush

</x-admin-layout>