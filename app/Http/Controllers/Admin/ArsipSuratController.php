<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ArsipSuratController extends Controller
{
    /**
     * Halaman beranda arsip surat dengan statistik dan riwayat terbaru
     */
    public function index()
    {
        // Statistik umum
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $suratMasukBulanIni = SuratMasuk::whereMonth('tanggal_terima', Carbon::now()->month)
                                      ->whereYear('tanggal_terima', Carbon::now()->year)
                                      ->count();
        $suratKeluarBulanIni = SuratKeluar::whereMonth('tanggal_surat', Carbon::now()->month)
                                        ->whereYear('tanggal_surat', Carbon::now()->year)
                                        ->count();

        // Riwayat surat masuk terbaru (5 terakhir)
        $suratMasukTerbaru = SuratMasuk::with('jenisSurat')
                                      ->orderBy('created_at', 'desc')
                                      ->limit(5)
                                      ->get();

        // Riwayat surat keluar terbaru (5 terakhir)
        $suratKeluarTerbaru = SuratKeluar::with('jenisSurat')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();

        // Statistik berdasarkan jenis surat bulan ini
        $statistikJenis = JenisSurat::withCount([
            'suratMasuk as masuk_count' => function ($query) {
                $query->whereMonth('tanggal_terima', Carbon::now()->month)
                      ->whereYear('tanggal_terima', Carbon::now()->year);
            },
            'suratKeluar as keluar_count' => function ($query) {
                $query->whereMonth('tanggal_surat', Carbon::now()->month)
                      ->whereYear('tanggal_surat', Carbon::now()->year);
            }
        ])->get();

        // Statistik disposisi surat masuk
        $disposisiStats = SuratMasuk::select('status_disposisi', DB::raw('count(*) as total'))
                                   ->groupBy('status_disposisi')
                                   ->pluck('total', 'status_disposisi')
                                   ->toArray();

        // Statistik status surat keluar
        $statusKeluarStats = SuratKeluar::select('status_kirim', DB::raw('count(*) as total'))
                                       ->groupBy('status_kirim')
                                       ->pluck('total', 'status_kirim')
                                       ->toArray();

        return view('admin.arsip-surat.index', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'suratMasukBulanIni',
            'suratKeluarBulanIni',
            'suratMasukTerbaru',
            'suratKeluarTerbaru',
            'statistikJenis',
            'disposisiStats',
            'statusKeluarStats'
        ));
    }

    /**
     * Halaman statistik dan grafik
     */
    public function statistik(Request $request)
    {
        $selectedYear = $request->get('tahun', date('Y'));
        $filterJenis = $request->get('jenis');
        $filterSifat = $request->get('sifat');

        // Base queries
        $queryMasuk = SuratMasuk::whereYear('tanggal_terima', $selectedYear);
        $queryKeluar = SuratKeluar::whereYear('tanggal_surat', $selectedYear);

        if ($filterJenis) {
            $queryMasuk->where('jenis_surat_id', $filterJenis);
            $queryKeluar->where('jenis_surat_id', $filterJenis);
        }

        if ($filterSifat) {
            $queryMasuk->where('sifat_surat', $filterSifat);
            $queryKeluar->where('sifat_surat', $filterSifat);
        }

        // Summary statistics
        $totalSuratMasuk = (clone $queryMasuk)->count();
        $totalSuratKeluar = (clone $queryKeluar)->count();
        $suratBulanIni = SuratMasuk::whereMonth('tanggal_terima', Carbon::now()->month)
                                  ->whereYear('tanggal_terima', Carbon::now()->year)
                                  ->count() +
                        SuratKeluar::whereMonth('tanggal_surat', Carbon::now()->month)
                                  ->whereYear('tanggal_surat', Carbon::now()->year)
                                  ->count();

        // Chart data - Bulanan
        $chartBulanan = [
            'labels' => [],
            'masuk' => [],
            'keluar' => []
        ];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $chartBulanan['labels'][] = Carbon::create(null, $bulan, 1)->format('M');
            $chartBulanan['masuk'][] = (clone $queryMasuk)->whereMonth('tanggal_terima', $bulan)->count();
            $chartBulanan['keluar'][] = (clone $queryKeluar)->whereMonth('tanggal_surat', $bulan)->count();
        }

        // Chart data - Jenis Surat
        $chartJenisSurat = ['labels' => [], 'data' => []];
        $jenisStats = JenisSurat::withCount([
            'suratMasuk as masuk_count' => function($query) use ($selectedYear, $filterJenis, $filterSifat) {
                $query->whereYear('tanggal_terima', $selectedYear);
                if ($filterJenis) $query->where('jenis_surat_id', $filterJenis);
                if ($filterSifat) $query->where('sifat_surat', $filterSifat);
            },
            'suratKeluar as keluar_count' => function($query) use ($selectedYear, $filterJenis, $filterSifat) {
                $query->whereYear('tanggal_surat', $selectedYear);
                if ($filterJenis) $query->where('jenis_surat_id', $filterJenis);
                if ($filterSifat) $query->where('sifat_surat', $filterSifat);
            }
        ])->having(DB::raw('masuk_count + keluar_count'), '>', 0)->get();

        foreach ($jenisStats as $jenis) {
            $chartJenisSurat['labels'][] = $jenis->nama_jenis;
            $chartJenisSurat['data'][] = $jenis->masuk_count + $jenis->keluar_count;
        }

        // Chart data - Sifat Surat
        $sifatSurat = ['Biasa', 'Penting', 'Segera', 'Rahasia'];
        $chartSifatSurat = ['labels' => $sifatSurat, 'data' => []];
        
        foreach ($sifatSurat as $sifat) {
            $count = SuratMasuk::where('sifat_surat', $sifat)
                              ->whereYear('tanggal_terima', $selectedYear)->count() +
                    SuratKeluar::where('sifat_surat', $sifat)
                              ->whereYear('tanggal_surat', $selectedYear)->count();
            $chartSifatSurat['data'][] = $count;
        }

        // Chart data - Status
        $statusDisposisi = ['Belum', 'Sudah', 'Selesai'];
        $statusPengiriman = ['Draft', 'Dikirim', 'Diterima'];
        
        $chartStatusSurat = [
            'labels' => array_merge($statusDisposisi, $statusPengiriman),
            'disposisi' => [],
            'pengiriman' => []
        ];

        foreach ($statusDisposisi as $status) {
            $chartStatusSurat['disposisi'][] = SuratMasuk::where('status_disposisi', $status)
                                                        ->whereYear('tanggal_terima', $selectedYear)->count();
        }

        foreach ($statusPengiriman as $status) {
            $chartStatusSurat['pengiriman'][] = SuratKeluar::where('status_kirim', $status)
                                                          ->whereYear('tanggal_surat', $selectedYear)->count();
        }

        // Chart data - Trend Tahunan (5 tahun terakhir)
        $chartTrendTahunan = ['labels' => [], 'masuk' => [], 'keluar' => []];
        
        for ($i = 4; $i >= 0; $i--) {
            $year = date('Y') - $i;
            $chartTrendTahunan['labels'][] = $year;
            $chartTrendTahunan['masuk'][] = SuratMasuk::whereYear('tanggal_terima', $year)->count();
            $chartTrendTahunan['keluar'][] = SuratKeluar::whereYear('tanggal_surat', $year)->count();
        }

        // Top Jenis Surat
        $topJenisSurat = JenisSurat::withCount([
            'suratMasuk as masuk_count',
            'suratKeluar as keluar_count'
        ])->get()
        ->map(function($jenis) {
            $jenis->total_count = $jenis->masuk_count + $jenis->keluar_count;
            return $jenis;
        })
        ->sortByDesc('total_count')
        ->take(5);

        // Monthly stats (6 bulan terakhir)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M Y');
            $monthlyStats[$month] = [
                'masuk' => SuratMasuk::whereMonth('tanggal_terima', $date->month)
                                    ->whereYear('tanggal_terima', $date->year)->count(),
                'keluar' => SuratKeluar::whereMonth('tanggal_surat', $date->month)
                                     ->whereYear('tanggal_surat', $date->year)->count()
            ];
        }

        $jenisSurat = JenisSurat::active()->get();

        // If AJAX request, return JSON data
        if ($request->ajax()) {
            return response()->json([
                'bulanan' => $chartBulanan,
                'jenisSurat' => $chartJenisSurat,
                'sifatSurat' => $chartSifatSurat,
                'statusSurat' => $chartStatusSurat,
                'summary' => [
                    'totalMasuk' => $totalSuratMasuk,
                    'totalKeluar' => $totalSuratKeluar,
                    'totalSemua' => $totalSuratMasuk + $totalSuratKeluar,
                    'bulanIni' => $suratBulanIni
                ]
            ]);
        }

        return view('admin.arsip-surat.statistik', compact(
            'selectedYear',
            'totalSuratMasuk',
            'totalSuratKeluar', 
            'suratBulanIni',
            'chartBulanan',
            'chartJenisSurat',
            'chartSifatSurat',
            'chartStatusSurat',
            'chartTrendTahunan',
            'topJenisSurat',
            'monthlyStats',
            'jenisSurat'
        ));
    }

    /**
     * Halaman laporan dengan filter
     */
    public function laporan(Request $request)
    {
        $filters = [
            'tanggal_mulai' => $request->get('tanggal_mulai'),
            'tanggal_selesai' => $request->get('tanggal_selesai'),
            'jenis_surat_id' => $request->get('jenis_surat_id'),
            'sifat_surat' => $request->get('sifat_surat'),
            'tipe_surat' => $request->get('tipe_surat', 'semua'), // masuk, keluar, atau semua
        ];

        $query = collect();

        if ($filters['tipe_surat'] === 'masuk' || $filters['tipe_surat'] === 'semua') {
            $suratMasukQuery = SuratMasuk::with('jenisSurat');
            
            if ($filters['tanggal_mulai']) {
                $suratMasukQuery->where('tanggal_terima', '>=', $filters['tanggal_mulai']);
            }
            if ($filters['tanggal_selesai']) {
                $suratMasukQuery->where('tanggal_terima', '<=', $filters['tanggal_selesai']);
            }
            if ($filters['jenis_surat_id']) {
                $suratMasukQuery->where('jenis_surat_id', $filters['jenis_surat_id']);
            }
            if ($filters['sifat_surat']) {
                $suratMasukQuery->where('sifat_surat', $filters['sifat_surat']);
            }

            $suratMasuk = $suratMasukQuery->get()->map(function ($item) {
                $item->tipe = 'Masuk';
                return $item;
            });

            $query = $query->merge($suratMasuk);
        }

        if ($filters['tipe_surat'] === 'keluar' || $filters['tipe_surat'] === 'semua') {
            $suratKeluarQuery = SuratKeluar::with('jenisSurat');
            
            if ($filters['tanggal_mulai']) {
                $suratKeluarQuery->where('tanggal_surat', '>=', $filters['tanggal_mulai']);
            }
            if ($filters['tanggal_selesai']) {
                $suratKeluarQuery->where('tanggal_surat', '<=', $filters['tanggal_selesai']);
            }
            if ($filters['jenis_surat_id']) {
                $suratKeluarQuery->where('jenis_surat_id', $filters['jenis_surat_id']);
            }
            if ($filters['sifat_surat']) {
                $suratKeluarQuery->where('sifat_surat', $filters['sifat_surat']);
            }

            $suratKeluar = $suratKeluarQuery->get()->map(function ($item) {
                $item->tipe = 'Keluar';
                return $item;
            });

            $query = $query->merge($suratKeluar);
        }

        $allData = $query->sortByDesc('created_at');
        $jenisSurat = JenisSurat::active()->get();

        // Statistics for filtered data  
        $totalSurat = $allData->count();
        $totalSuratMasuk = $allData->where('tipe', 'Masuk')->count();
        $totalSuratKeluar = $allData->where('tipe', 'Keluar')->count();

        // Create summary array for the view
        $summary = [
            'masuk' => $totalSuratMasuk,
            'keluar' => $totalSuratKeluar,
            'total' => $totalSurat,
            'berkas' => $allData->filter(function ($item) {
                return !empty($item->file_surat);
            })->count()
        ];

        // Paginate the collection manually for better performance
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $filteredData = new LengthAwarePaginator(
            $allData->forPage($currentPage, $perPage)->values(),
            $allData->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );

        return view('admin.arsip-surat.laporan', compact('filteredData', 'filters', 'jenisSurat', 'totalSurat', 'totalSuratMasuk', 'totalSuratKeluar', 'summary'));
    }

    /**
     * Export laporan ke Excel/PDF
     */
    public function exportLaporan(Request $request)
    {
        // Implementation for export functionality
        // This will be implemented with Laravel Excel package
        
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}
