<?php

namespace App\Models;

use App\Traits\DateFormatCreatedAttAndUpdatedAt;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('agama')]
#[Fillable(['nama'])]
class Agama extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;
}

