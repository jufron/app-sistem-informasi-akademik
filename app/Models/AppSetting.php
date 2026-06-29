<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Traits\DateFormatCreatedAttAndUpdatedAt;

#[Table('app_setting')]
#[Fillable(['key', 'value'])]
class AppSetting extends Model
{
    use DateFormatCreatedAttAndUpdatedAt;
}
