<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RuanganKelas;
use App\Models\MataPelajaran;
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
use Database\Seeders\JadwalPelajaranSeeder;
use Database\Seeders\RuanganKelasSeeder;
use Database\Seeders\AnggotaKelasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KepalaSekolahLaporanTest extends TestCase
{
    use RefreshDatabase;

    protected User $principalUser;
    protected User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RoleSeeder::class,
            AgamaSeeder::class,
            JenisKelaminSeeder::class,
            MataPelajaranSeeder::class,
            KelasSeeder::class,
            RombelSeeder::class,
            SemesterSeeder::class,
            GuruSeeder::class,
            RuanganKelasSeeder::class,
            JadwalPelajaranSeeder::class,
            SiswaSeeder::class,
            AnggotaKelasSeeder::class,
        ]);

        $this->principalUser = User::where('email', 'yohanes@mail.com')->firstOrFail();
        $this->otherUser = User::factory()->create();
    }

    /**
     * Test other users cannot access report center.
     */
    public function test_non_principal_cannot_access_laporan(): void
    {
        $response = $this->actingAs($this->otherUser)->get(route('dashboard.kepala-sekolah.laporan.index'));
        $response->assertStatus(403);
    }

    /**
     * Test principal can view laporan dashboard.
     */
    public function test_principal_can_view_laporan_index(): void
    {
        $response = $this->actingAs($this->principalUser)->get(route('dashboard.kepala-sekolah.laporan.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.laporan.index');
        $response->assertViewHasAll(['students', 'teachers', 'classrooms', 'subjects']);
    }

    /**
     * Test principal can access printable student layout.
     */
    public function test_principal_can_access_print_siswa(): void
    {
        $response = $this->actingAs($this->principalUser)->get(route('dashboard.kepala-sekolah.laporan.print-siswa'));
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.laporan.print-siswa');
        $response->assertSee('LAPORAN DATA INDUK SISWA');
    }

    /**
     * Test principal can access printable teacher layout.
     */
    public function test_principal_can_access_print_guru(): void
    {
        $response = $this->actingAs($this->principalUser)->get(route('dashboard.kepala-sekolah.laporan.print-guru'));
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.laporan.print-guru');
        $response->assertSee('LAPORAN DATA TENAGA PENDIDIK');
    }

    /**
     * Test principal can access printable grades layout.
     */
    public function test_principal_can_access_print_penilaian(): void
    {
        $classroom = RuanganKelas::firstOrFail();
        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();

        $response = $this->actingAs($this->principalUser)
            ->get(route('dashboard.kepala-sekolah.laporan.print-penilaian', [
                'ruangan_kelas_id'  => $classroom->id,
                'mata_pelajaran_id' => $subject->id,
            ]));
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.laporan.print-penilaian');
        $response->assertSee('DAFTAR NILAI AKADEMIK SISWA');
    }
}
