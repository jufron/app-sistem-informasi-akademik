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
        'nilai_tugas',
        'nilai_uh',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nilai_tugas' => 'float',
        'nilai_uh'    => 'float',
        'nilai_uts'   => 'float',
        'nilai_uas'   => 'float',
        'nilai_akhir' => 'float',
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
            $hasScore = ($nilai->nilai_tugas !== null) ||
                        ($nilai->nilai_uh !== null) ||
                        ($nilai->nilai_uts !== null) ||
                        ($nilai->nilai_uas !== null);

            if ($hasScore) {
                $tugas = $nilai->nilai_tugas ?? 0.0;
                $uh = $nilai->nilai_uh ?? 0.0;
                $uts = $nilai->nilai_uts ?? 0.0;
                $uas = $nilai->nilai_uas ?? 0.0;

                // Standard Indonesian school grading weight formula
                $nilai->nilai_akhir = ($tugas * 0.20) + ($uh * 0.20) + ($uts * 0.30) + ($uas * 0.30);
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
