<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSurat = [
            [
                'nama_jenis' => 'Surat Undangan',
                'deskripsi' => 'Surat undangan kegiatan resmi desa',
                'kode_jenis' => 'UND',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Keterangan',
                'deskripsi' => 'Surat keterangan berbagai keperluan warga',
                'kode_jenis' => 'KET',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Edaran',
                'deskripsi' => 'Surat edaran pengumuman atau pemberitahuan',
                'kode_jenis' => 'EDR',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Tugas',
                'deskripsi' => 'Surat tugas dan penugasan',
                'kode_jenis' => 'TGS',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Permohonan',
                'deskripsi' => 'Surat permohonan bantuan atau izin',
                'kode_jenis' => 'PER',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Keputusan',
                'deskripsi' => 'Surat keputusan kepala desa',
                'kode_jenis' => 'KEP',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Laporan',
                'deskripsi' => 'Surat laporan kegiatan atau pertanggungjawaban',
                'kode_jenis' => 'LAP',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Pemberitahuan',
                'deskripsi' => 'Surat pemberitahuan resmi',
                'kode_jenis' => 'BRT',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Rekomendasi',
                'deskripsi' => 'Surat rekomendasi dari desa',
                'kode_jenis' => 'REK',
                'is_active' => true,
            ],
            [
                'nama_jenis' => 'Surat Lainnya',
                'deskripsi' => 'Jenis surat lainnya yang tidak termasuk kategori di atas',
                'kode_jenis' => 'LAN',
                'is_active' => true,
            ],
        ];

        foreach ($jenisSurat as $jenis) {
            JenisSurat::create($jenis);
        }
    }
}
