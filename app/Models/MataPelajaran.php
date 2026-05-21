<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Table('mata_pelajaran')]
#[Fillable(['nama', 'deskripsi'])]
class MataPelajaran extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    /**
     * Get the teachers associated with the subject.
     */
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran', 'mata_pelajaran_id', 'guru_id');
    }

    // todo relasi/hubungan
    // penilaian
}