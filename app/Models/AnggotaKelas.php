<?php

namespace App\Models;

use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('anggota_kelas')]
#[Fillable([
    'siswa_id',
    'ruangan_kelas_id',
    'tanggal_masuk',
    'tanggal_keluar',
    'status',
    'keterangan',
])]
class AnggotaKelas extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the student associated with the class member.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Get the classroom associated with the class member.
     */
    public function ruanganKelas(): BelongsTo
    {
        return $this->belongsTo(RuanganKelas::class, 'ruangan_kelas_id');
    }
}
