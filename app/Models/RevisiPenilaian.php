<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('revisi_penilaian')]
#[Fillable([
    'ruangan_kelas_id',
    'mata_pelajaran_id',
    'pesan',
    'status',
])]
class RevisiPenilaian extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the classroom associated with the revision.
     */
    public function ruanganKelas(): BelongsTo
    {
        return $this->belongsTo(RuanganKelas::class, 'ruangan_kelas_id');
    }

    /**
     * Get the subject associated with the revision.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}
