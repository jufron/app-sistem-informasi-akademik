<?php

namespace App\Models;

use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('jadwal_pelajaran')]
#[Fillable([
    'guru_id',
    'mata_pelajaran_id',
    'kelas_id',
    'rombel_id',
    'semester_id',
    'ganjil_genap',
    'hari',
    'jam_mulai',
    'jam_selesai',
    'ruangan',
    'warna'
])]
class JadwalPelajaran extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the teacher associated with the schedule.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * Get the subject associated with the schedule.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    /**
     * Get the class associated with the schedule.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the rombel associated with the schedule.
     */
    public function rombel(): BelongsTo
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    /**
     * Get the semester associated with the schedule.
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}

