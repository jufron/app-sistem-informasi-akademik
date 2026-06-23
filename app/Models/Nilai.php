<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nilai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_id',
        'ruangan_kelas_id',
        'mata_pelajaran_id',
        'guru_id',
        'nilai_formatif',
        'nilai_sumatif_materi',
        'nilai_sumatif_akhir',
        'nilai_akhir',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nilai_formatif'       => 'float',
        'nilai_sumatif_materi' => 'float',
        'nilai_sumatif_akhir'  => 'float',
        'nilai_akhir'          => 'float',
    ];

    /**
     * The "booted" method of the model.
     *
     * Automatically calculates the final score (nilai_akhir) using weights:
     * Tugas: 20%, UH: 20%, UTS: 30%, UAS: 30%
     */
    protected static function booted(): void
    {
        static::saving(function (Nilai $nilai) {
            $hasSumatifMateri = $nilai->nilai_sumatif_materi !== null;
            $hasSumatifAkhir = $nilai->nilai_sumatif_akhir !== null;

            if ($hasSumatifMateri && $hasSumatifAkhir) {
                $nilai->nilai_akhir = ($nilai->nilai_sumatif_materi + $nilai->nilai_sumatif_akhir) / 2;
            } elseif ($hasSumatifMateri) {
                $nilai->nilai_akhir = $nilai->nilai_sumatif_materi;
            } elseif ($hasSumatifAkhir) {
                $nilai->nilai_akhir = $nilai->nilai_sumatif_akhir;
            } else {
                $nilai->nilai_akhir = null;
            }
        });
    }

    /**
     * Get the student that owns the grade.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Get the classroom associated with the grade.
     */
    public function ruanganKelas(): BelongsTo
    {
        return $this->belongsTo(RuanganKelas::class, 'ruangan_kelas_id');
    }

    /**
     * Get the subject associated with the grade.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    /**
     * Get the teacher who gave the grade.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
