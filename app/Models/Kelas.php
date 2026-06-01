<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('kelas')]
#[Fillable(['nama'])]
class Kelas extends Model
{
    /**
     * Get the ruangan kelas entries for the class.
     */
    public function ruanganKelas(): HasMany
    {
        return $this->hasMany(RuanganKelas::class, 'kelas_id');
    }
}


