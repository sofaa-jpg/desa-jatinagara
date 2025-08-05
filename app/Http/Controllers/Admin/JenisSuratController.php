<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Validator;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisSurat = JenisSurat::withCount(['suratMasuk', 'suratKeluar'])
                               ->orderBy('nama_jenis')
                               ->paginate(10);

        return view('admin.jenis-surat.index', compact('jenisSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jenis-surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required|string|max:255',
            'kode_jenis' => 'required|string|max:10|unique:jenis_surats',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        JenisSurat::create($request->all());

        return redirect()->route('admin.jenis-surat.index')
                        ->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisSurat $jenisSurat)
    {
        $jenisSurat->loadCount(['suratMasuk', 'suratKeluar']);
        return view('admin.jenis-surat.show', compact('jenisSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisSurat $jenisSurat)
    {
        return view('admin.jenis-surat.edit', compact('jenisSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required|string|max:255',
            'kode_jenis' => 'required|string|max:10|unique:jenis_surats,kode_jenis,' . $jenisSurat->id,
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $jenisSurat->update($request->all());

        return redirect()->route('admin.jenis-surat.index')
                        ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisSurat $jenisSurat)
    {
        // Check if jenis surat sedang digunakan
        if ($jenisSurat->suratMasuk()->count() > 0 || $jenisSurat->suratKeluar()->count() > 0) {
            return redirect()->route('admin.jenis-surat.index')
                           ->with('error', 'Jenis surat tidak dapat dihapus karena sedang digunakan pada surat lain.');
        }

        $jenisSurat->delete();

        return redirect()->route('admin.jenis-surat.index')
                        ->with('success', 'Jenis surat berhasil dihapus.');
    }

    /**
     * Toggle status aktif jenis surat
     */
    public function toggleStatus(JenisSurat $jenisSurat)
    {
        $jenisSurat->update(['is_active' => !$jenisSurat->is_active]);

        $status = $jenisSurat->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true, 
            'message' => "Jenis surat berhasil {$status}.",
            'is_active' => $jenisSurat->is_active
        ]);
    }

    /**
     * Get jenis surat for AJAX
     */
    public function getJenisSurat()
    {
        $jenisSurat = JenisSurat::active()->get(['id', 'nama_jenis', 'kode_jenis']);
        return response()->json($jenisSurat);
    }
}
