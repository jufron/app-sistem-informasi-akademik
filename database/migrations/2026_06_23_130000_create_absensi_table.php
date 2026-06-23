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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ruangan_kelas_id')
                ->constrained('ruangan_kelas')
                ->cascadeOnDelete();

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajaran')
                ->cascadeOnDelete();

            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->string('status'); // Hadir, Sakit, Izin, Alpa
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Unique constraint to prevent duplicate attendance records for a student per classroom/subject/date
            $table->unique(
                ['ruangan_kelas_id', 'mata_pelajaran_id', 'siswa_id', 'tanggal'],
                'absensi_kelas_mapel_siswa_tanggal_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
