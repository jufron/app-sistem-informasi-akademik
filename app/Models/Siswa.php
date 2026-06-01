<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('siswa')]
#[Fillable([
    'user_id',
    'nisn',
    'nis',
    'nama_lengkap',
    'nama_panggilan',
    'jenis_kelamin_id',
    'agama_id',
    'tempat_lahir',
    'tanggal_lahir',
    'telepon',
    'alamat',
    'foto',
    'status'
])]
class Siswa extends Model
{
    /**
     * Get the user account associated with the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the gender that belongs to the student.
     */
    public function jenisKelamin(): BelongsTo
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_id');
    }

    /**
     * Get the religion that belongs to the student.
     */
    public function agama(): BelongsTo
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    /**
     * Get the class members associated with the student.
     */
    public function anggotaKelas(): HasMany
    {
        return $this->hasMany(AnggotaKelas::class, 'siswa_id');
    }
}
