<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface AppSettingServiceInterface
{
    /**
     * Update the application settings.
     *
     * @param array $data Text input fields
     * @param array $files Uploaded file fields
     * @return void
     */
    public function updateSettings(array $data, array $files): void;
}
