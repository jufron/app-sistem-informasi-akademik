<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('guru')]
#[Fillable([
    'user_id',
    'nip',
    'nama_lengkap',
    'nama_panggilan',
    'jenis_kelamin_id',
    'agama_id',
    'tempat_lahir',
    'tanggal_lahir',
    'telepon',
    'alamat',
    'tipe',
    'foto',
    'status'
])]
class Guru extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the user account associated with the teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the subjects that the teacher teaches.
     */
    public function mataPelajaran(): BelongsToMany
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran', 'guru_id', 'mata_pelajaran_id');
    }

    /**
     * Get the lesson schedules for the teacher.
     */
    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'guru_id');
    }

    /**
     * Get the gender that belongs to the teacher.
     */
    public function jenisKelamin(): BelongsTo
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_id');
    }

    /**
     * Get the religion that belongs to the teacher.
     */
    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    /**
     * Get the ruangan kelas entries managed by this teacher (as wali kelas).
     */
    public function ruanganKelas(): HasMany
    {
        return $this->hasMany(RuanganKelas::class, 'guru_id');
    }
}


