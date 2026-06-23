<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\AppSetting;
use App\Repositories\Interfaces\AppSettingRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AppSettingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected AppSettingRepositoryInterface $appSettingRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->appSettingRepo = $this->app->make(AppSettingRepositoryInterface::class);
        Cache::flush();
    }

    /**
     * Test repository retrieves setting value.
     */
    public function test_get_value_returns_database_value_or_default(): void
    {
        // 1. Database is empty, should return default
        $value = $this->appSettingRepo->getValue('some_key', 'default_val');
        $this->assertEquals('default_val', $value);

        // 2. Insert setting in DB
        AppSetting::create([
            'key' => 'some_key',
            'value' => 'real_val'
        ]);

        // Clear cache so it hits DB
        Cache::flush();

        $value = $this->appSettingRepo->getValue('some_key', 'default_val');
        $this->assertEquals('real_val', $value);
    }

    /**
     * Test getValue caches retrieved settings.
     */
    public function test_get_value_caches_value(): void
    {
        AppSetting::create([
            'key' => 'cached_key',
            'value' => 'initial'
        ]);

        // First call - loads and caches
        $this->assertEquals('initial', $this->appSettingRepo->getValue('cached_key'));
        $this->assertTrue(Cache::has('app_setting_value_cached_key'));

        // Change database directly (bypassing repository)
        AppSetting::where('key', 'cached_key')->update(['value' => 'changed']);

        // Second call - should return cached value, not DB value
        $this->assertEquals('initial', $this->appSettingRepo->getValue('cached_key'));
    }

    /**
     * Test setValue updates database and invalidates cache.
     */
    public function test_set_value_updates_db_and_clears_cache(): void
    {
        // Cache a value
        $this->appSettingRepo->setValue('test_key', 'first');
        $this->assertEquals('first', $this->appSettingRepo->getValue('test_key'));
        $this->assertTrue(Cache::has('app_setting_value_test_key'));

        // Update value via repository
        $this->appSettingRepo->setValue('test_key', 'second');

        // Cache should be invalidated
        $this->assertFalse(Cache::has('app_setting_value_test_key'));
        $this->assertDatabaseHas('app_setting', [
            'key' => 'test_key',
            'value' => 'second'
        ]);
    }

    /**
     * Test getImageUrl falls back to placeholder and caches the result.
     */
    public function test_get_image_url_caching_and_fallbacks(): void
    {
        $url = $this->appSettingRepo->getImageUrl('hero_foto', 'http://fallback.com/image.jpg');
        
        $this->assertEquals('http://fallback.com/image.jpg', $url);
        $this->assertTrue(Cache::has('app_setting_image_url_hero_foto'));

        // Set value in DB (which would change image path)
        $this->appSettingRepo->setValue('hero_foto', 'assets/img/custom.jpg');

        // Setting a value invalidates image url cache
        $this->assertFalse(Cache::has('app_setting_image_url_hero_foto'));
    }

    /**
     * Test pluckKeyValue retrieves settings and caches it.
     */
    public function test_pluck_key_value_caching(): void
    {
        AppSetting::create(['key' => 'k1', 'value' => 'v1']);
        AppSetting::create(['key' => 'k2', 'value' => 'v2']);

        $plucked = $this->appSettingRepo->pluckKeyValue();
        $this->assertEquals(['k1' => 'v1', 'k2' => 'v2'], $plucked);
        $this->assertTrue(Cache::has('app_settings_pluck'));

        // setValue invalidates pluck cache
        $this->appSettingRepo->setValue('k3', 'v3');
        $this->assertFalse(Cache::has('app_settings_pluck'));
    }
}
