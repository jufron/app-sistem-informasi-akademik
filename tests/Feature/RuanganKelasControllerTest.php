<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\AnggotaKelas;
use App\Models\Guru;
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

class RuanganKelasControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed core lookups and roles so that test environment functions perfectly
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

        // Create an admin user and assign the admin role
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');
    }

    /**
     * Test index page rendering.
     */
    public function test_index_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.ruangan-kelas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.ruangan-kelas.index');
        $response->assertViewHasAll(['kelas', 'rombel', 'semester']);
    }

    /**
     * Test index page AJAX request returns Datatables JSON.
     */
    public function test_index_page_ajax_returns_json(): void
    {
        // Seed a sample classroom
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.ruangan-kelas.index'), [
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
        $this->assertEquals('2023', $data[0]['tahun_angkatan']);
        $this->assertEquals('2023/2024', $data[0]['tahun_ajaran']);
    }

    /**
     * Test create page renders successfully with necessary data variables.
     */
    public function test_create_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.ruangan-kelas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.ruangan-kelas.tambah');
        $response->assertViewHasAll(['kelas', 'rombel', 'semester', 'guru', 'siswa']);
    }

    /**
     * Test store method creates classroom and student pivot entries.
     */
    public function test_store_creates_classroom_successfully(): void
    {
        $student1 = Siswa::first();
        $student2 = Siswa::skip(1)->first();

        $formData = [
            'kelas_id'         => Kelas::first()->id,
            'rombel_id'        => Rombel::first()->id,
            'semester_id'      => Semester::first()->id,
            'guru_id'          => Guru::first()->id,
            'tahun_angkatan'   => '2024',
            'tahun_ajaran'     => '2024/2025',
            'aktif'            => '1',
            'siswa_ids'        => [$student1->id, $student2->id],
            'tanggal_masuks'   => ['2024-07-15', '2024-07-16'],
            'tanggal_keluars'  => [null, null],
            'statuses'         => ['Aktif', 'Aktif'],
            'keterangans'      => ['Siswa A', 'Siswa B'],
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.ruangan-kelas.store'), $formData);

        $response->assertRedirect(route('dashboard.ruangan-kelas.index'));
        
        $this->assertDatabaseHas('ruangan_kelas', [
            'tahun_angkatan' => '2024',
            'tahun_ajaran'   => '2024/2025',
            'aktif'          => 1,
        ]);

        $classroom = RuanganKelas::latest()->first();

        $this->assertDatabaseHas('anggota_kelas', [
            'siswa_id'         => $student1->id,
            'ruangan_kelas_id' => $classroom->id,
            'tanggal_masuk'    => '2024-07-15',
            'status'           => 'Aktif',
            'keterangan'       => 'Siswa A',
        ]);

        $this->assertDatabaseHas('anggota_kelas', [
            'siswa_id'         => $student2->id,
            'ruangan_kelas_id' => $classroom->id,
            'tanggal_masuk'    => '2024-07-16',
            'status'           => 'Aktif',
            'keterangan'       => 'Siswa B',
        ]);
    }

    /**
     * Test show method returns nested relations JSON successfully.
     */
    public function test_show_returns_json_successfully(): void
    {
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $student = Siswa::first();
        AnggotaKelas::create([
            'siswa_id'         => $student->id,
            'ruangan_kelas_id' => $classroom->id,
            'tanggal_masuk'    => '2023-07-15',
            'status'           => 'Aktif',
            'keterangan'       => 'Regular member',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->getJson(route('dashboard.ruangan-kelas.show', $classroom));

        $response->assertStatus(200);
        $response->assertJsonPath('tahun_angkatan', '2023');
        $response->assertJsonPath('tahun_ajaran', '2023/2024');
        $response->assertJsonStructure([
            'kelas',
            'rombel',
            'semester',
            'guru',
            'anggota_kelas' => [
                '*' => [
                    'siswa'
                ]
            ]
        ]);
    }

    /**
     * Test edit page renders successfully with prefilled variables.
     */
    public function test_edit_page_renders_successfully(): void
    {
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('dashboard.ruangan-kelas.edit', $classroom));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.ruangan-kelas.ubah');
        $response->assertViewHasAll(['ruanganKelas', 'kelas', 'rombel', 'semester', 'guru', 'siswa']);
    }

    /**
     * Test update action synchronizes classroom attributes and dynamic pivot students.
     */
    public function test_update_saves_changes_successfully(): void
    {
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $student1 = Siswa::first();
        $student2 = Siswa::skip(1)->first();

        // Initial enrollment
        AnggotaKelas::create([
            'siswa_id'         => $student1->id,
            'ruangan_kelas_id' => $classroom->id,
            'tanggal_masuk'    => '2023-07-15',
            'status'           => 'Aktif',
        ]);

        // Form submit with new classroom parameters and synchronized student list
        $updatedData = [
            'kelas_id'         => Kelas::first()->id,
            'rombel_id'        => Rombel::first()->id,
            'semester_id'      => Semester::first()->id,
            'guru_id'          => Guru::first()->id,
            'tahun_angkatan'   => '2023',
            'tahun_ajaran'     => '2023/2024',
            'aktif'            => '1',
            'siswa_ids'        => [$student2->id], // student1 removed, student2 added
            'tanggal_masuks'   => ['2023-08-01'],
            'tanggal_keluars'  => [null],
            'statuses'         => ['Naik Kelas'],
            'keterangans'      => ['Pindah'],
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('dashboard.ruangan-kelas.update', $classroom), $updatedData);

        $response->assertRedirect(route('dashboard.ruangan-kelas.index'));

        // Old mapping should be wiped
        $this->assertDatabaseMissing('anggota_kelas', [
            'siswa_id'         => $student1->id,
            'ruangan_kelas_id' => $classroom->id,
        ]);

        // New mapping should be written
        $this->assertDatabaseHas('anggota_kelas', [
            'siswa_id'         => $student2->id,
            'ruangan_kelas_id' => $classroom->id,
            'tanggal_masuk'    => '2023-08-01',
            'status'           => 'Naik Kelas',
            'keterangan'       => 'Pindah',
        ]);
    }

    /**
     * Test destroy deletes a classroom.
     */
    public function test_destroy_deletes_classroom_successfully(): void
    {
        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete(route('dashboard.ruangan-kelas.destroy', $classroom));

        $response->assertRedirect(route('dashboard.ruangan-kelas.index'));
        $this->assertDatabaseMissing('ruangan_kelas', ['id' => $classroom->id]);
    }

    /**
     * Test bulkDestroy deletes selected classrooms.
     */
    public function test_bulk_destroy_deletes_successfully(): void
    {
        $c1 = RuanganKelas::create([
            'kelas_id' => Kelas::first()->id, 'rombel_id' => Rombel::first()->id,
            'semester_id' => Semester::first()->id, 'guru_id' => Guru::first()->id,
            'tahun_angkatan' => '2023', 'tahun_ajaran' => '2023/2024', 'aktif' => true
        ]);
        $c2 = RuanganKelas::create([
            'kelas_id' => Kelas::first()->id, 'rombel_id' => Rombel::first()->id,
            'semester_id' => Semester::first()->id, 'guru_id' => Guru::first()->id,
            'tahun_angkatan' => '2023', 'tahun_ajaran' => '2023/2024', 'aktif' => true
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('dashboard.ruangan-kelas.bulk-destroy'), [
                'ids' => [$c1->id, $c2->id]
            ]);

        $response->assertRedirect(route('dashboard.ruangan-kelas.index'));
        $this->assertDatabaseMissing('ruangan_kelas', ['id' => $c1->id]);
        $this->assertDatabaseMissing('ruangan_kelas', ['id' => $c2->id]);
    }

    /**
     * Test PDF download generates downloadable pdf stream.
     */
    public function test_pdf_download_returns_pdf_stream(): void
    {
        \Spatie\LaravelPdf\Facades\Pdf::fake();

        $classroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => Semester::first()->id,
            'guru_id'        => Guru::first()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('dashboard.ruangan-kelas.pdf', $classroom));

        $response->assertStatus(200);
    }
}
