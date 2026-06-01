<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('rombel')]
#[Fillable(['nama'])]
class Rombel extends Model
{
    /**
     * Get the ruangan kelas entries for this rombel.
     */
    public function ruanganKelas(): HasMany
    {
        return $this->hasMany(RuanganKelas::class, 'rombel_id');
    }
}


