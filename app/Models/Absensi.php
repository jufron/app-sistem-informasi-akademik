<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('absensi')]
#[Fillable([
    'ruangan_kelas_id',
    'mata_pelajaran_id',
    'siswa_id',
    'guru_id',
    'tanggal',
    'status',
    'keterangan',
])]
class Absensi extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the classroom associated with the attendance record.
     */
    public function ruanganKelas(): BelongsTo
    {
        return $this->belongsTo(RuanganKelas::class, 'ruangan_kelas_id');
    }

    /**
     * Get the subject associated with the attendance record.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    /**
     * Get the student associated with the attendance record.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Get the teacher who recorded the attendance.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
