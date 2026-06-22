<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_setting';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set/Update a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return \App\Models\AppSetting
     */
    public static function setValue(string $key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get image URL for a setting key, with safety fallback to default/placeholder.
     *
     * @param string $key
     * @param string|null $defaultUrl
     * @return string
     */
    public static function getImageUrl(string $key, ?string $defaultUrl = null): string
    {
        $value = self::getValue($key);
        
        // If there is no value in settings
        if (empty($value)) {
            return $defaultUrl ?? self::getDefaultPlaceholder($key);
        }

        // If it starts with 'assets/', it's a seed asset
        if (str_starts_with($value, 'assets/')) {
            if (file_exists(public_path($value))) {
                return asset($value);
            }
            return $defaultUrl ?? self::getDefaultPlaceholder($key);
        }

        // Otherwise, check if the file exists in the public disk storage
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($value)) {
            return asset('storage/' . $value);
        }

        // Fallback to placeholder/default if file doesn't exist
        return $defaultUrl ?? self::getDefaultPlaceholder($key);
    }

    /**
     * Get a default online or local placeholder for the given setting key.
     *
     * @param string $key
     * @return string
     */
    private static function getDefaultPlaceholder(string $key): string
    {
        switch ($key) {
            case 'logo_sekolah':
                return file_exists(public_path('img/logo-bg.png')) 
                    ? asset('img/logo-bg.png') 
                    : 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=300&auto=format&fit=crop';
            case 'foto_kepala_sekolah':
                return 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974&auto=format&fit=crop';
            case 'hero_foto':
                return 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=2070&auto=format&fit=crop';
            case 'struktur_organisasi':
                return 'https://images.unsplash.com/photo-1531538606174-0f90ff5dce83?q=80&w=1974&auto=format&fit=crop';
            case 'foto_sertifikat_akreditasi':
                return 'https://images.unsplash.com/photo-1589330694653-ded6df53f7ee?q=80&w=1974&auto=format&fit=crop';
            default:
                return 'https://via.placeholder.com/300x150?text=No+Image';
        }
    }
}
