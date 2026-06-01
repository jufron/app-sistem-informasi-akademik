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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('nisn')->nullable()->unique();
            $table->string('nis')->nullable()->unique();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->foreignId('jenis_kelamin_id')->constrained('jenis_kelamin')->cascadeOnDelete();
            $table->foreignId('agama_id')->constrained('agama')->cascadeOnDelete();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('telepon')->nullable();
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
