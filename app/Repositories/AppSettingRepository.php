<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AppSetting;
use App\Repositories\Interfaces\AppSettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class AppSettingRepository
 * 
 * Repository implementation for managing application settings (AppSetting) with caching support.
 */
class AppSettingRepository implements AppSettingRepositoryInterface
{
    /**
     * Retrieve all application settings. Cached for 7 days.
     *
     * @return Collection<int, AppSetting>
     */
    public function getAll(): Collection
    {
        return Cache::remember('app_settings_all', now()->addDays(7), function () {
            return AppSetting::all();
        });
    }

    /**
     * Find a specific application setting by ID.
     *
     * @param int|string $id
     * @return AppSetting|null
     */
    public function findById(int|string $id): ?AppSetting
    {
        return AppSetting::find($id);
    }

    /**
     * Create a new application setting. Clears related cache keys.
     *
     * @param array $data
     * @return AppSetting
     */
    public function create(array $data): AppSetting
    {
        $setting = AppSetting::create($data);
        $this->clearCache($setting->key);
        return $setting;
    }

    /**
     * Update an existing application setting. Clears related cache keys.
     *
     * @param int|string $id
     * @param array $data
     * @return AppSetting
     */
    public function update(int|string $id, array $data): AppSetting
    {
        $setting = AppSetting::findOrFail($id);
        $oldKey = $setting->key;
        $setting->update($data);
        
        $this->clearCache($oldKey);
        if (isset($data['key']) && $data['key'] !== $oldKey) {
            $this->clearCache($data['key']);
        }
        
        return $setting;
    }

    /**
     * Delete an application setting. Clears related cache keys.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $setting = AppSetting::find($id);
        if ($setting) {
            $key = $setting->key;
            $deleted = (bool) $setting->delete();
            if ($deleted) {
                $this->clearCache($key);
            }
            return $deleted;
        }
        return false;
    }

    /**
     * Get a setting value by key. Cached for 7 days.
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getValue(string $key, ?string $default = null): ?string
    {
        return Cache::remember('app_setting_value_' . $key, now()->addDays(7), function () use ($key, $default) {
            $setting = AppSetting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set or update a setting value. Clears related cache keys.
     *
     * @param string $key
     * @param string $value
     * @return AppSetting
     */
    public function setValue(string $key, string $value): AppSetting
    {
        $setting = AppSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        $this->clearCache($key);
        return $setting;
    }

    /**
     * Get the image URL for a setting key. Cached for 7 days.
     *
     * @param string $key
     * @param string|null $defaultUrl
     * @return string
     */
    public function getImageUrl(string $key, ?string $defaultUrl = null): string
    {
        return Cache::remember('app_setting_image_url_' . $key, now()->addDays(7), function () use ($key, $defaultUrl) {
            $value = $this->getValue($key);
            
            // If there is no value in settings
            if (empty($value)) {
                return $defaultUrl ?? $this->getDefaultPlaceholder($key);
            }

            // If it starts with 'assets/', it's a seed asset
            if (str_starts_with($value, 'assets/')) {
                if (file_exists(public_path($value))) {
                    return asset($value);
                }
                return $defaultUrl ?? $this->getDefaultPlaceholder($key);
            }

            // Otherwise, check if the file exists in the public disk storage
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($value)) {
                return asset('storage/' . $value);
            }

            // Fallback to placeholder/default if file doesn't exist
            return $defaultUrl ?? $this->getDefaultPlaceholder($key);
        });
    }

    /**
     * Get a default online or local placeholder for the given setting key.
     *
     * @param string $key
     * @return string
     */
    private function getDefaultPlaceholder(string $key): string
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

    /**
     * Get key-value pairs of all settings. Cached for 7 days.
     *
     * @return array
     */
    public function pluckKeyValue(): array
    {
        return Cache::remember('app_settings_pluck', now()->addDays(7), function () {
            return AppSetting::pluck('value', 'key')->all();
        });
    }

    /**
     * Helper method to clear all cache keys related to a specific setting key.
     *
     * @param string $key
     * @return void
     */
    private function clearCache(string $key): void
    {
        Cache::forget('app_setting_value_' . $key);
        Cache::forget('app_setting_image_url_' . $key);
        Cache::forget('app_settings_all');
        Cache::forget('app_settings_pluck');
    }
}

