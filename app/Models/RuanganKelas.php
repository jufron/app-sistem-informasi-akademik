<?php

namespace App\Models;

use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('ruangan_kelas')]
#[Fillable([
    'kelas_id',
    'rombel_id',
    'semester_id',
    'guru_id',
    'tahun_angkatan',
    'tahun_ajaran',
    'aktif',
])]
class RuanganKelas extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the class associated with the ruangan kelas.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the rombel associated with the ruangan kelas.
     */
    public function rombel(): BelongsTo
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    /**
     * Get the semester associated with the ruangan kelas.
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get the teacher (wali kelas) associated with the ruangan kelas.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * Get the members associated with this classroom.
     */
    public function anggotaKelas(): HasMany
    {
        return $this->hasMany(AnggotaKelas::class, 'ruangan_kelas_id');
    }
}
