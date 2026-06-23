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
            return AppSetting::getValue($key, $default);
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
        $setting = AppSetting::setValue($key, $value);
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
            return AppSetting::getImageUrl($key, $defaultUrl);
        });
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

