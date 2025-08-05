<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratKeluar::with('jenisSurat');

        // Filter berdasarkan parameter
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('sifat_surat')) {
            $query->where('sifat_surat', $request->sifat_surat);
        }

        if ($request->filled('status_kirim')) {
            $query->where('status_kirim', $request->status_kirim);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_surat', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_surat', '<=', $request->tanggal_selesai);
        }

        $suratKeluar = $query->orderBy('tanggal_surat', 'desc')
                            ->paginate(10)
                            ->appends($request->query());

        $jenisSurat = JenisSurat::active()->get();

        return view('admin.surat-keluar.index', compact('suratKeluar', 'jenisSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisSurat = JenisSurat::active()->get();
        return view('admin.surat-keluar.create', compact('jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:surat_keluars',
            'perihal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'alamat_tujuan' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_kirim' => 'nullable|date',
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'isi_ringkas' => 'nullable|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'status_kirim' => 'required|in:Draft,Dikirim,Diterima',
            'catatan' => 'nullable|string',
            'tembusan' => 'nullable|string|max:255',
            'penandatangan' => 'nullable|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-keluar', $filename, 'public');
            $data['file_surat'] = $filename;
        }

        SuratKeluar::create($data);

        return redirect()->route('admin.surat-keluar.index')
                        ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('jenisSurat');
        return view('admin.surat-keluar.show', compact('suratKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $jenisSurat = JenisSurat::active()->get();
        return view('admin.surat-keluar.edit', compact('suratKeluar', 'jenisSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:surat_keluars,nomor_surat,' . $suratKeluar->id,
            'perihal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'alamat_tujuan' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_kirim' => 'nullable|date',
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'isi_ringkas' => 'nullable|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'status_kirim' => 'required|in:Draft,Dikirim,Diterima',
            'catatan' => 'nullable|string',
            'tembusan' => 'nullable|string|max:255',
            'penandatangan' => 'nullable|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($suratKeluar->file_surat && Storage::disk('public')->exists('surat-keluar/' . $suratKeluar->file_surat)) {
                Storage::disk('public')->delete('surat-keluar/' . $suratKeluar->file_surat);
            }

            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-keluar', $filename, 'public');
            $data['file_surat'] = $filename;
        }

        $suratKeluar->update($data);

        return redirect()->route('admin.surat-keluar.index')
                        ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        // Delete file if exists
        if ($suratKeluar->file_surat && Storage::disk('public')->exists('surat-keluar/' . $suratKeluar->file_surat)) {
            Storage::disk('public')->delete('surat-keluar/' . $suratKeluar->file_surat);
        }

        $suratKeluar->delete();

        return redirect()->route('admin.surat-keluar.index')
                        ->with('success', 'Surat keluar berhasil dihapus.');
    }

    /**
     * Download file surat
     */
    public function downloadFile(SuratKeluar $suratKeluar)
    {
        if (!$suratKeluar->file_surat || !Storage::disk('public')->exists('surat-keluar/' . $suratKeluar->file_surat)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download('surat-keluar/' . $suratKeluar->file_surat);
    }

    /**
     * Update status kirim surat
     */
    public function updateStatus(Request $request, SuratKeluar $suratKeluar)
    {
        $validator = Validator::make($request->all(), [
            'status_kirim' => 'required|in:Draft,Dikirim,Diterima',
            'tanggal_kirim' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $suratKeluar->update($request->all());

        return response()->json(['success' => true, 'message' => 'Status surat berhasil diperbarui.']);
    }
}
