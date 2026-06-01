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
        Schema::create('anggota_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->foreignId('ruangan_kelas_id')
                ->constrained('ruangan_kelas')
                ->cascadeOnDelete();

            $table->date('tanggal_masuk');

            $table->date('tanggal_keluar')
                ->nullable();

            $table->enum('status', [
                'Aktif',
                'Naik Kelas',
                'Tinggal Kelas',
                'Mutasi Keluar',
                'Mutasi Masuk',
                'Lulus',
                'Keluar',
            ])->default('Aktif');

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_kelas');
    }
};
