<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengajuanSuratController extends Controller
{
    /**
     * Menampilkan daftar semua pengajuan surat
     */
    public function index(Request $request)
    {
        $query = PengajuanSurat::query();

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', 'like', '%' . $request->jenis_surat . '%');
        }

        // Search berdasarkan nama atau NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $pengajuanList = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistik untuk dashboard
        $statistik = [
            'total' => PengajuanSurat::count(),
            'pending' => PengajuanSurat::where('status', PengajuanSurat::STATUS_PENDING)->count(),
            'diproses' => PengajuanSurat::where('status', PengajuanSurat::STATUS_IN_PROGRESS)->count(),
            'selesai' => PengajuanSurat::where('status', PengajuanSurat::STATUS_COMPLETED)->count(),
            'ditolak' => PengajuanSurat::where('status', PengajuanSurat::STATUS_REJECTED)->count(),
        ];

        return view('admin.pengajuan_surat.index', compact('pengajuanList', 'statistik'));
    }

    /**
     * Menampilkan detail pengajuan surat
     */
    public function show(PengajuanSurat $pengajuanSurat)
    {
        return view('admin.pengajuan_surat.show', compact('pengajuanSurat'));
    }

    /**
     * Mengubah status pengajuan surat
     */
    public function updateStatus(Request $request, PengajuanSurat $pengajuanSurat)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pengajuanSurat->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
            ]);

            $statusLabel = [
                'pending' => 'Menunggu Diproses',
                'diproses' => 'Sedang Diproses', 
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak'
            ];

            return redirect()->back()
                ->with('success', 'Status pengajuan berhasil diubah menjadi: ' . $statusLabel[$request->status]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengubah status. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus pengajuan surat
     */
    public function destroy(PengajuanSurat $pengajuanSurat)
    {
        try {
            $pengajuanSurat->delete();

            return redirect()->route('admin.pengajuan-surat.index')
                ->with('success', 'Pengajuan surat berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pengajuan.');
        }
    }

    /**
     * Export pengajuan surat ke Excel/CSV
     */
    public function export(Request $request)
    {
        $query = PengajuanSurat::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $pengajuanList = $query->orderBy('created_at', 'desc')->get();

        $filename = 'pengajuan_surat_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($pengajuanList) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID', 
                'Nama', 
                'NIK', 
                'Jenis Surat', 
                'Status', 
                'Tanggal Pengajuan', 
                'Alamat', 
                'No. Telepon', 
                'Email',
                'Keperluan',
                'Catatan Admin'
            ]);

            // Data rows
            foreach ($pengajuanList as $pengajuan) {
                fputcsv($file, [
                    $pengajuan->id,
                    $pengajuan->nama,
                    $pengajuan->nik,
                    $pengajuan->jenis_surat,
                    ucfirst($pengajuan->status),
                    $pengajuan->created_at->format('Y-m-d H:i:s'),
                    $pengajuan->alamat,
                    $pengajuan->no_telepon,
                    $pengajuan->email,
                    $pengajuan->keperluan,
                    $pengajuan->catatan_admin
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 