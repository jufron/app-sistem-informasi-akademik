<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AppSetting;
use App\Services\Interfaces\AppSettingServiceInterface;
use Illuminate\Support\Facades\Storage;

class AppSettingService implements AppSettingServiceInterface
{
    /**
     * Update the application settings.
     *
     * @param array $data Text input fields
     * @param array $files Uploaded file fields
     * @return void
     */
    public function updateSettings(array $data, array $files): void
    {
        $textFields = [
            'nama_sekolah',
            'nama_kepala_sekolah',
            'sambutan_kepala_sekolah',
            'sejarah',
            'visi',
            'misi',
            'akreditasi',
            'nomor_telepon_kantor',
            'nomor_telepon_whatsapp',
            'email',
            'alamat_sekolah',
            'link_facebook',
            'link_instagram',
            'link_email',
        ];

        foreach ($textFields as $field) {
            if (array_key_exists($field, $data)) {
                AppSetting::setValue($field, $data[$field]);
            }
        }

        foreach ($files as $field => $file) {
            if ($file && $file->isValid()) {
                // Delete the old file if it exists in storage (excluding default assets path)
                $oldValue = AppSetting::getValue($field);
                if ($oldValue && !str_starts_with($oldValue, 'assets/') && Storage::disk('public')->exists($oldValue)) {
                    Storage::disk('public')->delete($oldValue);
                }
                
                // Store the new file
                $path = $file->store('settings', 'public');
                AppSetting::setValue($field, $path);
            }
        }
    }
}
