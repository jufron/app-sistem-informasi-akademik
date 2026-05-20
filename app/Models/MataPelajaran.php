<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Table('mata_pelajaran')]
#[Fillable(['nama', 'deskripsi'])]
class MataPelajaran extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;

    // todo relasi/hubungan
    // guru
    // penilaian
    
}