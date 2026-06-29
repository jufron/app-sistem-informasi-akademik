<?php

if (!function_exists('get_app_setting')) {
    /**
     * Get a setting value by key via the AppSettingRepository.
     *
     * @param string $key
     * @param mixed $default
     * @return string|null
     */
    function get_app_setting(string $key, $default = null): ?string
    {
        return app(\App\Repositories\Interfaces\AppSettingRepositoryInterface::class)->getValue($key, $default);
    }
}

if (!function_exists('get_app_setting_url')) {
    /**
     * Get the image URL for a setting key via the AppSettingRepository.
     *
     * @param string $key
     * @param string|null $defaultUrl
     * @return string
     */
    function get_app_setting_url(string $key, ?string $defaultUrl = null): string
    {
        return app(\App\Repositories\Interfaces\AppSettingRepositoryInterface::class)->getImageUrl($key, $defaultUrl);
    }
}
