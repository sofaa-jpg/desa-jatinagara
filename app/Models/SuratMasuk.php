<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SuratMasuk extends Model
{
    protected $fillable = [
        'nomor_surat',
        'perihal',
        'pengirim',
        'alamat_pengirim',
        'tanggal_surat',
        'tanggal_terima',
        'jenis_surat_id',
        'isi_ringkas',
        'sifat_surat',
        'status_disposisi',
        'file_surat',
        'catatan',
        'disposisi_kepada',
        'tanggal_disposisi',
        'instruksi_disposisi'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima' => 'date',
        'tanggal_disposisi' => 'date',
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
        $query = $query->whereYear('tanggal_terima', $tahun);
        
        if ($bulan) {
            $query = $query->whereMonth('tanggal_terima', $bulan);
        }
        
        return $query;
    }

    public function scopeBySifat($query, $sifat)
    {
        return $query->where('sifat_surat', $sifat);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_disposisi', $status);
    }

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file_surat ? asset('storage/surat-masuk/' . $this->file_surat) : null
        );
    }
}
