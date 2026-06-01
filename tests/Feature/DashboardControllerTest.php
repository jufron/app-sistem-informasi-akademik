<?php

namespace Tests\Feature;

use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\RuanganKelas;
use App\Models\Rombel;
use App\Models\JadwalPelajaran;
use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\Kelas;
use App\Models\Semester;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles so Spatie Role works correctly in the test environment
        $this->seed(RoleSeeder::class);
    }

    /**
     * Test 1: Verify the controller class exists, has correct namespace, name, and inheritance.
     */
    public function test_controller_class_name_and_inheritance(): void
    {
        $controllerClass = DashboardController::class;

        // Check if class exists
        $this->assertTrue(class_exists($controllerClass), "DashboardController class does not exist.");

        // Check namespace and class name match
        $this->assertEquals('App\Http\Controllers\DashboardController', $controllerClass);

        // Check if class base name is exactly DashboardController
        $reflection = new ReflectionClass($controllerClass);
        $this->assertEquals('DashboardController', $reflection->getShortName(), "The controller class name is not correct.");

        // Check inheritance
        $this->assertTrue(
            is_subclass_of($controllerClass, 'App\Http\Controllers\Controller'),
            "DashboardController must extend App\Http\Controllers\Controller."
        );
    }

    /**
     * Test 2: Verify that the dashboard method exists and is public in the controller.
     */
    public function test_controller_has_dashboard_method(): void
    {
        $controllerClass = DashboardController::class;
        $reflection = new ReflectionClass($controllerClass);

        $this->assertTrue(
            $reflection->hasMethod('dashboard'),
            "Method 'dashboard' is missing in DashboardController."
        );

        $method = $reflection->getMethod('dashboard');
        $this->assertTrue(
            $method->isPublic(),
            "Method 'dashboard' in DashboardController must be public."
        );
    }

    /**
     * Test 3: Verify the route is mapped correctly and protected by auth middleware.
     */
    public function test_route_path_and_middleware(): void
    {
        // 1. Verify Route URL matches the name
        $this->assertEquals(url('/dashboard'), route('dashboard'), "Route 'dashboard' does not resolve to the correct URL.");

        // 2. Verify that the route uses the correct controller and action
        $route = app('router')->getRoutes()->getByName('dashboard');
        $this->assertNotNull($route, "Route 'dashboard' is not registered.");
        $this->assertEquals(
            DashboardController::class . '@dashboard',
            $route->getActionName(),
            "Route 'dashboard' is not mapped to the correct controller action."
        );

        // 3. Verify that the route has auth middleware applied
        $this->assertContains('auth', $route->middleware(), "Route 'dashboard' is missing the 'auth' middleware protection.");

        // 4. Verify unauthenticated/guest users are redirected to the login page
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test 4: Verify Dashboard view and data when logged in as an ADMIN.
     */
    public function test_dashboard_renders_admin_view_with_correct_data(): void
    {
        // 1. Setup required lookup values
        $agamaIslam = Agama::create(['nama' => 'Islam']);
        $agamaKristen = Agama::create(['nama' => 'Kristen Protestan']);

        $jkLaki = JenisKelamin::create(['nama' => 'Laki-laki', 'kode' => 'L']);
        $jkPerempuan = JenisKelamin::create(['nama' => 'Perempuan', 'kode' => 'P']);

        // 2. Setup Siswa data (2 siswa, different genders, religions, and status)
        $userSiswa1 = User::factory()->create();
        $userSiswa1->assignRole('siswa');
        Siswa::create([
            'user_id' => $userSiswa1->id,
            'nisn' => '1000000001',
            'nis' => '10001',
            'nama_lengkap' => 'Siswa Laki Islam',
            'nama_panggilan' => 'SiswaL',
            'jenis_kelamin_id' => $jkLaki->id,
            'agama_id' => $agamaIslam->id,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-01-01',
            'telepon' => '08123456789',
            'alamat' => 'Jakarta',
            'status' => 'Aktif',
        ]);

        $userSiswa2 = User::factory()->create();
        $userSiswa2->assignRole('siswa');
        Siswa::create([
            'user_id' => $userSiswa2->id,
            'nisn' => '1000000002',
            'nis' => '10002',
            'nama_lengkap' => 'Siswa Perempuan Kristen',
            'nama_panggilan' => 'SiswaP',
            'jenis_kelamin_id' => $jkPerempuan->id,
            'agama_id' => $agamaKristen->id,
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2010-02-02',
            'telepon' => '08123456780',
            'alamat' => 'Surabaya',
            'status' => 'Lulus',
        ]);

        // 3. Setup Guru (1 guru)
        $userGuru = User::factory()->create();
        $userGuru->assignRole('guru');
        $guru = Guru::create([
            'user_id' => $userGuru->id,
            'nip' => '2000000001',
            'nama_lengkap' => 'Guru Laki',
            'nama_panggilan' => 'GuruL',
            'jenis_kelamin_id' => $jkLaki->id,
            'agama_id' => $agamaIslam->id,
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1980-01-01',
            'telepon' => '08123456788',
            'alamat' => 'Bandung',
            'tipe' => 'Bukan Wali Kelas',
            'status' => 'Aktif',
        ]);

        // 4. Setup Mata Pelajaran
        $mapel = MataPelajaran::create([
            'nama' => 'Matematika',
            'deskripsi' => 'Belajar matematika'
        ]);

        // 5. Setup Rombel, Kelas, Semester
        $rombel = Rombel::create(['nama' => 'VII-A']);
        $kelas = Kelas::create(['nama' => 'VII']);
        $semester = Semester::create(['nama' => 'Ganjil']);

        // 6. Setup Ruangan Kelas
        $ruangan = RuanganKelas::create([
            'kelas_id' => $kelas->id,
            'rombel_id' => $rombel->id,
            'semester_id' => $semester->id,
            'guru_id' => $guru->id,
            'tahun_angkatan' => 2026,
            'tahun_ajaran' => '2026/2027',
            'aktif' => 1,
        ]);

        // 7. Setup Jadwal Pelajaran
        $jadwal = JadwalPelajaran::create([
            'guru_id' => $guru->id,
            'mata_pelajaran_id' => $mapel->id,
            'kelas_id' => $kelas->id,
            'rombel_id' => $rombel->id,
            'semester_id' => $semester->id,
            'ganjil_genap' => 'Ganjil',
            'hari' => 'Senin',
            'jam_mulai' => '07:00:00',
            'jam_selesai' => '08:30:00',
            'ruangan' => 'R-1',
            'warna' => '#000000',
        ]);

        // Create user and assign 'admin' role
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.dashboard');
        
        // Assert User
        $response->assertViewHas('user', function ($viewUser) use ($admin) {
            return $viewUser->id === $admin->id;
        });

        // Assert Counts
        $response->assertViewHas('totalSiswa', 2);
        $response->assertViewHas('totalGuru', 1);
        $response->assertViewHas('totalMapel', 1);
        $response->assertViewHas('totalRombel', 1);
        $response->assertViewHas('totalRuangan', 1);
        $response->assertViewHas('totalJadwal', 1);

        // Assert Gender Data
        $response->assertViewHas('genderData', function ($genderData) {
            $laki = $genderData->firstWhere('name', 'Laki-laki');
            $perempuan = $genderData->firstWhere('name', 'Perempuan');
            return $laki && $laki->total == 1 && $perempuan && $perempuan->total == 1;
        });

        // Assert Religion Data
        $response->assertViewHas('agamaData', function ($agamaData) {
            $islam = $agamaData->firstWhere('name', 'Islam');
            $kristen = $agamaData->firstWhere('name', 'Kristen Protestan');
            return $islam && $islam->total == 1 && $kristen && $kristen->total == 1;
        });

        // Assert Status Data
        $response->assertViewHas('statusData', function ($statusData) {
            $aktif = $statusData->firstWhere('name', 'Aktif');
            $lulus = $statusData->firstWhere('name', 'Lulus');
            return $aktif && $aktif->total == 1 && $lulus && $lulus->total == 1;
        });
    }

    /**
     * Test 5: Verify Dashboard view and data when logged in as a GURU.
     */
    public function test_dashboard_renders_guru_view_with_correct_data(): void
    {
        // Create user and assign 'guru' role
        $guru = User::factory()->create();
        $guru->assignRole('guru');

        $response = $this->actingAs($guru)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($guru) {
            return $viewUser->id === $guru->id;
        });
    }

    /**
     * Test 6: Verify Dashboard view and data when logged in as KEPALA SEKOLAH.
     */
    public function test_dashboard_renders_kepala_sekolah_view_with_correct_data(): void
    {
        // Create user and assign 'kepala-sekolah' role
        $kepalaSekolah = User::factory()->create();
        $kepalaSekolah->assignRole('kepala-sekolah');

        $response = $this->actingAs($kepalaSekolah)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($kepalaSekolah) {
            return $viewUser->id === $kepalaSekolah->id;
        });
    }

    /**
     * Test 7: Verify Dashboard view and data when logged in as a SISWA.
     */
    public function test_dashboard_renders_siswa_view_with_correct_data(): void
    {
        // Create user and assign 'siswa' role
        $siswa = User::factory()->create();
        $siswa->assignRole('siswa');

        $response = $this->actingAs($siswa)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.siswa.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($siswa) {
            return $viewUser->id === $siswa->id;
        });
    }

    /**
     * Test 8: Verify Dashboard view and data when logged in as a user with NO role.
     */
    public function test_dashboard_renders_fallback_view_for_roleless_user(): void
    {
        // Create user with no roles
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewMissing('user');
    }
}
