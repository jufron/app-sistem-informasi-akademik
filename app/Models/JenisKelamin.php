<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Table('jenis_kelamin')]
#[Fillable(['nama', 'kode'])]
class JenisKelamin extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;
}
