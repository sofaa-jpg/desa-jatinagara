<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::with('jenisSurat');

        // Filter berdasarkan parameter
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('sifat_surat')) {
            $query->where('sifat_surat', $request->sifat_surat);
        }

        if ($request->filled('status_disposisi')) {
            $query->where('status_disposisi', $request->status_disposisi);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('pengirim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_terima', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_terima', '<=', $request->tanggal_selesai);
        }

        $suratMasuk = $query->orderBy('tanggal_terima', 'desc')
                           ->paginate(10)
                           ->appends($request->query());

        $jenisSurat = JenisSurat::active()->get();

        return view('admin.surat-masuk.index', compact('suratMasuk', 'jenisSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisSurat = JenisSurat::active()->get();
        return view('admin.surat-masuk.create', compact('jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:surat_masuks',
            'perihal' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'alamat_pengirim' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'isi_ringkas' => 'nullable|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'status_disposisi' => 'required|in:Belum,Sudah,Selesai',
            'catatan' => 'nullable|string',
            'disposisi_kepada' => 'nullable|string|max:255',
            'tanggal_disposisi' => 'nullable|date',
            'instruksi_disposisi' => 'nullable|string',
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
            $path = $file->storeAs('surat-masuk', $filename, 'public');
            $data['file_surat'] = $filename;
        }

        SuratMasuk::create($data);

        return redirect()->route('admin.surat-masuk.index')
                        ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('jenisSurat');
        return view('admin.surat-masuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        $jenisSurat = JenisSurat::active()->get();
        return view('admin.surat-masuk.edit', compact('suratMasuk', 'jenisSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:surat_masuks,nomor_surat,' . $suratMasuk->id,
            'perihal' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'alamat_pengirim' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'isi_ringkas' => 'nullable|string',
            'sifat_surat' => 'required|in:Biasa,Penting,Segera,Rahasia',
            'status_disposisi' => 'required|in:Belum,Sudah,Selesai',
            'catatan' => 'nullable|string',
            'disposisi_kepada' => 'nullable|string|max:255',
            'tanggal_disposisi' => 'nullable|date',
            'instruksi_disposisi' => 'nullable|string',
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
            if ($suratMasuk->file_surat && Storage::disk('public')->exists('surat-masuk/' . $suratMasuk->file_surat)) {
                Storage::disk('public')->delete('surat-masuk/' . $suratMasuk->file_surat);
            }

            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-masuk', $filename, 'public');
            $data['file_surat'] = $filename;
        }

        $suratMasuk->update($data);

        return redirect()->route('admin.surat-masuk.index')
                        ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        // Delete file if exists
        if ($suratMasuk->file_surat && Storage::disk('public')->exists('surat-masuk/' . $suratMasuk->file_surat)) {
            Storage::disk('public')->delete('surat-masuk/' . $suratMasuk->file_surat);
        }

        $suratMasuk->delete();

        return redirect()->route('admin.surat-masuk.index')
                        ->with('success', 'Surat masuk berhasil dihapus.');
    }

    /**
     * Download file surat
     */
    public function downloadFile(SuratMasuk $suratMasuk)
    {
        if (!$suratMasuk->file_surat || !Storage::disk('public')->exists('surat-masuk/' . $suratMasuk->file_surat)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download('surat-masuk/' . $suratMasuk->file_surat);
    }

    /**
     * Update disposisi surat
     */
    public function updateDisposisi(Request $request, SuratMasuk $suratMasuk)
    {
        $validator = Validator::make($request->all(), [
            'status_disposisi' => 'required|in:Belum,Sudah,Selesai',
            'disposisi_kepada' => 'nullable|string|max:255',
            'tanggal_disposisi' => 'nullable|date',
            'instruksi_disposisi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $suratMasuk->update($request->all());

        return response()->json(['success' => true, 'message' => 'Disposisi berhasil diperbarui.']);
    }
}
