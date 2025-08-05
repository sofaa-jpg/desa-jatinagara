<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('perihal');
            $table->string('pengirim');
            $table->string('alamat_pengirim')->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')->onDelete('restrict');
            $table->text('isi_ringkas')->nullable();
            $table->enum('sifat_surat', ['Biasa', 'Penting', 'Segera', 'Rahasia'])->default('Biasa');
            $table->enum('status_disposisi', ['Belum', 'Sudah', 'Selesai'])->default('Belum');
            $table->string('file_surat')->nullable();
            $table->text('catatan')->nullable();
            $table->string('disposisi_kepada')->nullable();
            $table->date('tanggal_disposisi')->nullable();
            $table->text('instruksi_disposisi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
