<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use App\Models\AppSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once app_path('Helpers/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('app_setting')) {
                $settings = AppSetting::pluck('value', 'key')->all();
                view()->share('app_settings', $settings);
            }
        } catch (\Exception $e) {
            // Silence DB errors during setup/console commands
        }
    }
}
