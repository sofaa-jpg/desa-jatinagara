<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'kode_jenis',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function suratMasuk(): HasMany
    {
        return $this->hasMany(SuratMasuk::class);
    }

    public function suratKeluar(): HasMany
    {
        return $this->hasMany(SuratKeluar::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
