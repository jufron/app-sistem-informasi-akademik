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
     * Test guest users are redirected to login for views.
     */
    public function test_guest_users_cannot_access_settings(): void
    {
        $response = $this->get(route('dashboard.app-setting.index'));

        $response->assertRedirect('/login');
    }

    /**
     * Test guest users cannot update settings.
     */
    public function test_guest_users_cannot_update_settings(): void
    {
        $response = $this->put(route('dashboard.app-setting.update'), [
            'nama_sekolah' => 'Guest School Title Update',
        ]);

        $response->assertRedirect('/login');
    }

    /**
     * Test non-admin users receive 403 forbidden for views.
     */
    public function test_non_admin_users_cannot_access_settings(): void
    {
        $response = $this->actingAs($this->nonAdminUser)->get(route('dashboard.app-setting.index'));

        $response->assertStatus(403);
    }

    /**
     * Test non-admin users cannot update settings.
     */
    public function test_non_admin_users_cannot_update_settings(): void
    {
        $response = $this->actingAs($this->nonAdminUser)->put(route('dashboard.app-setting.update'), [
            'nama_sekolah' => 'Non-Admin School Title Update',
        ]);

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
            'link_youtube' => 'https://youtube.com/sekolahbaru',
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
     * Test settings update validation fails for invalid file types.
     */
    public function test_update_settings_invalid_files_validation_fails(): void
    {
        // Uploading a text file instead of an image
        $textDoc = UploadedFile::fake()->create('not_an_image.txt', 100);

        $invalidData = [
            'nama_sekolah' => 'SMA Valid',
            'nama_kepala_sekolah' => 'Kepsek Valid',
            'sambutan_kepala_sekolah' => 'Sambutan Valid',
            'sejarah' => 'Sejarah Valid',
            'visi' => 'Visi Valid',
            'misi' => 'Misi Valid',
            'akreditasi' => 'A',
            'nomor_telepon_kantor' => '021-111111',
            'nomor_telepon_whatsapp' => '081111111111',
            'email' => 'valid@sekolah.sch.id',
            'alamat_sekolah' => 'Alamat Valid',
            'logo_sekolah' => $textDoc, // invalid file type (should be image)
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.app-setting.update'), $invalidData);

        $response->assertSessionHasErrors(['logo_sekolah']);
    }

    /**
     * Test settings update successfully with all five uploaded files.
     */
    public function test_update_settings_with_all_files_successfully(): void
    {
        Storage::fake('public');

        $logo = UploadedFile::fake()->image('logo.png');
        $hero = UploadedFile::fake()->image('hero.jpg');
        $kepsek = UploadedFile::fake()->image('kepsek.png');
        $struktur = UploadedFile::fake()->image('struktur.png');
        $akreditasi = UploadedFile::fake()->image('akreditasi.jpg');

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
            'foto_kepala_sekolah' => $kepsek,
            'struktur_organisasi' => $struktur,
            'foto_sertifikat_akreditasi' => $akreditasi,
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.app-setting.update'), $settingsData);

        $response->assertRedirect(route('dashboard.app-setting.index'));

        // Retrieve and assert setting records are saved and present in disk
        $fileKeys = [
            'logo_sekolah',
            'hero_foto',
            'foto_kepala_sekolah',
            'struktur_organisasi',
            'foto_sertifikat_akreditasi',
        ];

        foreach ($fileKeys as $key) {
            $setting = AppSetting::where('key', $key)->first();
            $this->assertNotNull($setting);
            $this->assertNotEmpty($setting->value);
            Storage::disk('public')->assertExists($setting->value);
        }
    }

    /**
     * Test updating a setting file deletes the old file from storage.
     */
    public function test_updating_setting_file_deletes_old_file(): void
    {
        Storage::fake('public');

        // Setup an existing setting with an old file path in the database
        $oldFilePath = 'settings/old_logo.png';
        Storage::disk('public')->put($oldFilePath, 'old_logo_content');

        // Update database setting record value
        $logoSetting = AppSetting::where('key', 'logo_sekolah')->first();
        if ($logoSetting) {
            $logoSetting->update(['value' => $oldFilePath]);
        } else {
            AppSetting::create(['key' => 'logo_sekolah', 'value' => $oldFilePath]);
        }

        // Assert old file exists before updating
        Storage::disk('public')->assertExists($oldFilePath);

        // Upload a new file
        $newLogo = UploadedFile::fake()->image('new_logo.png');

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
            'logo_sekolah' => $newLogo,
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.app-setting.update'), $settingsData);

        $response->assertRedirect(route('dashboard.app-setting.index'));

        // Assert old file was deleted from storage disk
        Storage::disk('public')->assertMissing($oldFilePath);

        // Assert new file exists in storage disk
        $updatedLogoSetting = AppSetting::where('key', 'logo_sekolah')->first();
        $this->assertNotEquals($oldFilePath, $updatedLogoSetting->value);
        Storage::disk('public')->assertExists($updatedLogoSetting->value);
    }
}
