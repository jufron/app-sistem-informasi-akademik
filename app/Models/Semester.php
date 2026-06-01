<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('semester')]
#[Fillable(['nama'])]
class Semester extends Model
{
    /**
     * Get the ruangan kelas entries for this semester.
     */
    public function ruanganKelas(): HasMany
    {
        return $this->hasMany(RuanganKelas::class, 'semester_id');
    }
}


