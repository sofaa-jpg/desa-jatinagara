<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnlineServiceController extends Controller
{
    /**
     * Menampilkan halaman utama layanan online
     */
    public function index()
    {
        $jenisServices = [
            'pengajuan_surat' => [
                'title' => 'Pengajuan Surat Online',
                'description' => 'Ajukan berbagai jenis surat keterangan secara online',
                'icon' => '📄',
                'types' => [
                    'domicile_certificate' => 'Surat Keterangan Domisili',
                    'ownership_certificate' => 'Surat Keterangan Kepemilikan Hewan',
                    'business_certificate' => 'Surat Keterangan Usaha',
                    'income_certificate' => 'Surat Keterangan Penghasilan',
                    'birth_certificate' => 'Surat Keterangan Kelahiran',
                    'death_certificate' => 'Surat Keterangan Kematian',
                    'poverty_certificate' => 'Surat Keterangan Tidak Mampu',
                    'single_certificate' => 'Surat Keterangan Belum Menikah'
                ]
            ],
            'permohonan_dokumen' => [
                'title' => 'Permohonan Dokumen Desa',
                'description' => 'Minta dokumen resmi desa secara online',
                'icon' => '📋',
                'types' => [
                    'village_profile' => 'Profil Desa',
                    'village_data' => 'Data Desa Terkini',
                    'population_data' => 'Data Kependudukan',
                    'village_map' => 'Peta Wilayah Desa'
                ]
            ]
        ];

        return view('frontend.online_services', compact('jenisServices'));
    }

    /**
     * Menampilkan form pengajuan surat
     */
    public function createSurat($jenis = null)
    {
        $jenisOptions = [
            'domicile_certificate' => 'Surat Keterangan Domisili',
            'ownership_certificate' => 'Surat Keterangan Kepemilikan Hewan',
            'business_certificate' => 'Surat Keterangan Usaha',
            'income_certificate' => 'Surat Keterangan Penghasilan',
            'birth_certificate' => 'Surat Keterangan Kelahiran',
            'death_certificate' => 'Surat Keterangan Kematian',
            'poverty_certificate' => 'Surat Keterangan Tidak Mampu',
            'single_certificate' => 'Surat Keterangan Belum Menikah'
        ];

        return view('frontend.online_services_form', compact('jenisOptions', 'jenis'));
    }

    /**
     * Menyimpan pengajuan surat baru
     */
    public function storeSurat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'jenis_surat' => 'required|string',
            'keperluan' => 'required|string|max:1000',
            'alamat' => 'required|string|max:500',
            'no_telepon' => 'required|string|max:15',
            'email' => 'nullable|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pengajuan = PengajuanSurat::create([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'jenis_surat' => $request->jenis_surat,
                'keperluan' => $request->keperluan,
                'status' => PengajuanSurat::STATUS_PENDING,
            ]);

            return redirect()->route('online-services.status', $pengajuan->id)
                ->with('success', 'Pengajuan surat berhasil dikirim! Silakan catat nomor pengajuan Anda: #' . str_pad($pengajuan->id, 6, '0', STR_PAD_LEFT));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengajuan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Cek status pengajuan surat
     */
    public function checkStatus(Request $request, $id = null)
    {
        if ($request->isMethod('GET') && $id) {
            $pengajuan = PengajuanSurat::find($id);
            
            if (!$pengajuan) {
                return redirect()->route('online-services')
                    ->with('error', 'Pengajuan tidak ditemukan.');
            }

            return view('frontend.online_services_status', compact('pengajuan'));
        }

        // Untuk pencarian berdasarkan NIK atau ID
        if ($request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'search_type' => 'required|in:id,nik',
                'search_value' => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $query = PengajuanSurat::query();
            
            if ($request->search_type === 'id') {
                $id = (int) $request->search_value;
                $query->where('id', $id);
            } else {
                $query->where('nik', $request->search_value);
            }

            $pengajuanList = $query->orderBy('created_at', 'desc')->get();

            return view('frontend.online_services_status', compact('pengajuanList'));
        }

        return view('frontend.online_services_status');
    }
} 