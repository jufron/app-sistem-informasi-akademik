<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait DateFormatCreatedAttAndUpdatedAt
{
    /**
     * Get the user's created_at.
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d F Y'),
        );
    }

    /**
     * Get the user's updated_at.
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d F Y'),
        );
    }
}
