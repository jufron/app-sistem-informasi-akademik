<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use App\Models\AppSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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
