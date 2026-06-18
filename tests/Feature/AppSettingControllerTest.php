<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AppSettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AppSettingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $nonAdminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles & initial settings
        $this->seed(RoleSeeder::class);
        $this->seed(AppSettingSeeder::class);

        // Create an admin user
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');

        // Create a non-admin user (e.g. guru)
        $this->nonAdminUser = User::factory()->create();
        $this->nonAdminUser->assignRole('guru');
    }

    /**
     * Test index page renders successfully for admin.
     */
    public function test_index_page_renders_successfully_for_admin(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.app-setting.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.app-setting.index');
        $response->assertViewHas('settings');
    }

    /**
     * Test edit page renders successfully for admin.
     */
    public function test_edit_page_renders_successfully_for_admin(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.app-setting.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.app-setting.edit');
        $response->assertViewHas('settings');
    }

    /**
     * Test guest users are redirected to login.
     */
    public function test_guest_users_cannot_access_settings(): void
    {
        $response = $this->get(route('dashboard.app-setting.index'));

        $response->assertRedirect('/login');
    }

    /**
     * Test non-admin users receive 403 forbidden.
     */
    public function test_non_admin_users_cannot_access_settings(): void
    {
        $response = $this->actingAs($this->nonAdminUser)->get(route('dashboard.app-setting.index'));

        $response->assertStatus(403);
    }

    /**
     * Test settings update successfully for valid text data.
     */
    public function test_update_settings_successfully(): void
    {
        $settingsData = [
            'nama_sekolah' => 'Sekolah Menengah Atas Baru',
            'nama_kepala_sekolah' => 'Kepala Baru, M.Pd.',
            'sambutan_kepala_sekolah' => 'Sambutan kepala baru.',
            'sejarah' => 'Sejarah baru sekolah.',
            'visi' => 'Visi baru.',
            'misi' => 'Misi baru.',
            'akreditasi' => 'B',
            'nomor_telepon_kantor' => '021-999999',
            'nomor_telepon_whatsapp' => '089999999999',
            'email' => 'admin.baru@sekolah.sch.id',
            'alamat_sekolah' => 'Alamat baru sekolah.',
            'link_facebook' => 'https://facebook.com/sekolahbaru',
            'link_instagram' => 'https://instagram.com/sekolahbaru',
            'link_email' => 'mailto:admin.baru@sekolah.sch.id',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.app-setting.update'), $settingsData);

        $response->assertRedirect(route('dashboard.app-setting.index'));
        
        // Assert setting values are updated in the database
        foreach ($settingsData as $key => $value) {
            $this->assertDatabaseHas('app_setting', [
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    /**
     * Test settings validation rules fail for invalid data.
     */
    public function test_update_settings_validation_fails(): void
    {
        // Leaving required field 'nama_sekolah' empty
        $invalidData = [
            'nama_sekolah' => '',
            'nama_kepala_sekolah' => 'Kepala Baru, M.Pd.',
            'sambutan_kepala_sekolah' => 'Sambutan.',
            'sejarah' => 'Sejarah.',
            'visi' => 'Visi.',
            'misi' => 'Misi.',
            'akreditasi' => 'A',
            'nomor_telepon_kantor' => '021-999999',
            'nomor_telepon_whatsapp' => '089999999999',
            'email' => 'bukan-email', // invalid email format
            'alamat_sekolah' => 'Alamat.',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.app-setting.update'), $invalidData);

        $response->assertSessionHasErrors(['nama_sekolah', 'email']);
    }

    /**
     * Test settings update successfully with uploaded files.
     */
    public function test_update_settings_with_files_successfully(): void
    {
        Storage::fake('public');

        $logo = UploadedFile::fake()->image('logo.png');
        $hero = UploadedFile::fake()->image('hero.jpg');

        $settingsData = [
            'nama_sekolah' => 'SMA Test',
            'nama_kepala_sekolah' => 'Kepsek Test',
            'sambutan_kepala_sekolah' => 'Sambutan Test',
            'sejarah' => 'Sejarah Test',
            'visi' => 'Visi Test',
            'misi' => 'Misi Test',
            'akreditasi' => 'A',
            'nomor_telepon_kantor' => '021-111111',
            'nomor_telepon_whatsapp' => '081111111111',
            'email' => 'test@sekolah.sch.id',
            'alamat_sekolah' => 'Alamat Test',
            'logo_sekolah' => $logo,
            'hero_foto' => $hero,
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.app-setting.update'), $settingsData);

        $response->assertRedirect(route('dashboard.app-setting.index'));

        // Retrieve setting records
        $logoSetting = AppSetting::where('key', 'logo_sekolah')->first();
        $heroSetting = AppSetting::where('key', 'hero_foto')->first();

        $this->assertNotNull($logoSetting);
        $this->assertNotNull($heroSetting);

        // Assert file exists in the public disk
        Storage::disk('public')->assertExists($logoSetting->value);
        Storage::disk('public')->assertExists($heroSetting->value);
    }
}
