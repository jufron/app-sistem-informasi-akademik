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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            $table->foreignId('ruangan_kelas_id')
                ->constrained('ruangan_kelas')
                ->cascadeOnDelete();

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajaran')
                ->cascadeOnDelete();

            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnDelete();

            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uh', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Prevent duplicate grades for a single student on a single subject in a classroom
            $table->unique(['siswa_id', 'ruangan_kelas_id', 'mata_pelajaran_id'], 'nilai_unique_siswa_kelas_mapel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
