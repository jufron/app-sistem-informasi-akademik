<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Agama;
use App\Models\Guru;
use App\Models\JenisKelamin;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\RuanganKelas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\User;
use Database\Seeders\AgamaSeeder;
use Database\Seeders\GuruSeeder;
use Database\Seeders\JenisKelaminSeeder;
use Database\Seeders\KelasSeeder;
use Database\Seeders\MataPelajaranSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RombelSeeder;
use Database\Seeders\SemesterSeeder;
use Database\Seeders\SiswaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruRuanganKelasControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $guruUser;
    protected User $nonGuruUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed all the required lookup and core data
        $this->seed([
            RoleSeeder::class,
            AgamaSeeder::class,
            JenisKelaminSeeder::class,
            MataPelajaranSeeder::class,
            KelasSeeder::class,
            RombelSeeder::class,
            SemesterSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
        ]);

        // Create user with "guru" role
        $this->guruUser = User::factory()->create();
        $this->guruUser->assignRole('guru');

        // Create standard user with no "guru" role
        $this->nonGuruUser = User::factory()->create();
    }

    /**
     * Test guests are redirected to login.
     */
    public function test_guest_cannot_access_guru_ruangan_kelas(): void
    {
        $response = $this->get(route('dashboard.guru.ruangan-kelas.index'));
        $response->assertRedirect('/login');
    }

    /**
     * Test users without guru role cannot access guru ruangan kelas.
     */
    public function test_non_guru_user_cannot_access_guru_ruangan_kelas(): void
    {
        $response = $this->actingAs($this->nonGuruUser)->get(route('dashboard.guru.ruangan-kelas.index'));
        $response->assertStatus(403);
    }

    /**
     * Test index page renders successfully for a user with the guru role.
     */
    public function test_index_page_renders_successfully_for_guru(): void
    {
        $response = $this->actingAs($this->guruUser)->get(route('dashboard.guru.ruangan-kelas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.ruangan-kelas.index');
        $response->assertViewHasAll(['kelas', 'rombel', 'semester']);
    }

    /**
     * Test index page AJAX request returns Datatables JSON.
     */
    public function test_index_page_ajax_returns_json_for_guru(): void
    {
        // Seed classroom
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2025',
            'tahun_ajaran'   => '2025/2026',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->guruUser)
            ->getJson(route('dashboard.guru.ruangan-kelas.index'), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('2025', $data[0]['tahun_angkatan']);
    }

    /**
     * Test showing classroom details.
     */
    public function test_show_classroom_details_renders_successfully(): void
    {
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2025',
            'tahun_ajaran'   => '2025/2026',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->guruUser)
            ->get(route('dashboard.guru.ruangan-kelas.show', $classroom->id));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.ruangan-kelas.show');
        $response->assertViewHas('ruanganKelas');
        
        $viewClassroom = $response->viewData('ruanganKelas');
        $this->assertEquals($classroom->id, $viewClassroom->id);
    }

    /**
     * Test show classroom with invalid ID returns 404.
     */
    public function test_show_invalid_classroom_id_returns_404(): void
    {
        $response = $this->actingAs($this->guruUser)
            ->get(route('dashboard.guru.ruangan-kelas.show', 999999));

        $response->assertStatus(404);
    }

    /**
     * Test showing student details.
     */
    public function test_show_siswa_details_renders_successfully(): void
    {
        $siswa = Siswa::first();
        $this->assertNotNull($siswa);

        $response = $this->actingAs($this->guruUser)
            ->get(route('dashboard.guru.siswa.show', $siswa->id));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.siswa.show');
        $response->assertViewHas('siswa');
        
        $viewSiswa = $response->viewData('siswa');
        $this->assertEquals($siswa->id, $viewSiswa->id);
    }

    /**
     * Test show student with invalid ID returns 404.
     */
    public function test_show_invalid_siswa_id_returns_404(): void
    {
        $response = $this->actingAs($this->guruUser)
            ->get(route('dashboard.guru.siswa.show', 999999));

        $response->assertStatus(404);
    }
}
