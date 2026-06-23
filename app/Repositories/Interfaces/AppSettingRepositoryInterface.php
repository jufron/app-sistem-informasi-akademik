<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\AppSetting;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface AppSettingRepositoryInterface
 * 
 * Contract for managing application settings (AppSetting) database operations.
 */
interface AppSettingRepositoryInterface
{
    /**
     * Retrieve all application settings.
     *
     * @return Collection<int, AppSetting>
     */
    public function getAll(): Collection;

    /**
     * Find a specific application setting by ID.
     *
     * @param int|string $id
     * @return AppSetting|null
     */
    public function findById(int|string $id): ?AppSetting;

    /**
     * Create a new application setting.
     *
     * @param array $data
     * @return AppSetting
     */
    public function create(array $data): AppSetting;

    /**
     * Update an existing application setting.
     *
     * @param int|string $id
     * @param array $data
     * @return AppSetting
     */
    public function update(int|string $id, array $data): AppSetting;
    
    /**
     * Delete an application setting.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getValue(string $key, ?string $default = null): ?string;

    /**
     * Set or update a setting value.
     *
     * @param string $key
     * @param string $value
     * @return AppSetting
     */
    public function setValue(string $key, string $value): AppSetting;

    /**
     * Get the image URL for a setting key.
     *
     * @param string $key
     * @param string|null $defaultUrl
     * @return string
     */
    public function getImageUrl(string $key, ?string $defaultUrl = null): string;

    /**
     * Get key-value pairs of all settings.
     *
     * @return array
     */
    public function pluckKeyValue(): array;
}

