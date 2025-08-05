<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SuratKeluar extends Model
{
    protected $fillable = [
        'nomor_surat',
        'perihal',
        'tujuan',
        'alamat_tujuan',
        'tanggal_surat',
        'tanggal_kirim',
        'jenis_surat_id',
        'isi_ringkas',
        'sifat_surat',
        'status_kirim',
        'file_surat',
        'catatan',
        'tembusan',
        'penandatangan'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_kirim' => 'date',
    ];

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function scopeByJenis($query, $jenisId)
    {
        return $query->where('jenis_surat_id', $jenisId);
    }

    public function scopeByPeriode($query, $tahun, $bulan = null)
    {
        $query = $query->whereYear('tanggal_surat', $tahun);
        
        if ($bulan) {
            $query = $query->whereMonth('tanggal_surat', $bulan);
        }
        
        return $query;
    }

    public function scopeBySifat($query, $sifat)
    {
        return $query->where('sifat_surat', $sifat);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_kirim', $status);
    }

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file_surat ? asset('storage/surat-keluar/' . $this->file_surat) : null
        );
    }
}
