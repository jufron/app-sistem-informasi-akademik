<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RuanganKelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\User;
use App\Models\RevisiPenilaian;
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

class KepalaSekolahPenilaianTest extends TestCase
{
    use RefreshDatabase;

    protected User $principalUser;
    protected User $teacherUser;

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

        // Yohanes Don Bosco is the kepala-sekolah
        $this->principalUser = User::where('email', 'yohanes@mail.com')->firstOrFail();

        // Antonius Budi is a teacher
        $this->teacherUser = User::where('email', 'antonius@mail.com')->firstOrFail();
    }

    /**
     * Test principal can view dashboard with classroom details.
     */
    public function test_principal_can_view_dashboard_with_classrooms(): void
    {
        $response = $this->actingAs($this->principalUser)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.dashboard');
        $response->assertViewHas('classrooms');
    }

    /**
     * Test principal can view student grades read-only.
     */
    public function test_principal_can_view_grades_read_only(): void
    {
        $classroom = RuanganKelas::firstOrFail();
        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();

        $response = $this->actingAs($this->principalUser)
            ->get(route('dashboard', [
                'ruangan_kelas_id'  => $classroom->id,
                'mata_pelajaran_id' => $subject->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewHasAll(['selectedClassroomId', 'selectedSubjectId', 'gradesSheet', 'revisions']);
    }

    /**
     * Test principal can create a revision message.
     */
    public function test_principal_can_create_revision_message(): void
    {
        $classroom = RuanganKelas::firstOrFail();
        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();

        $postData = [
            'ruangan_kelas_id'  => $classroom->id,
            'mata_pelajaran_id' => $subject->id,
            'pesan'             => 'Tolong tinjau kembali nilainya.',
        ];

        $response = $this->actingAs($this->principalUser)
            ->post(route('dashboard.kepala-sekolah.revisi.store'), $postData);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('revisi_penilaian', [
            'ruangan_kelas_id'  => $classroom->id,
            'mata_pelajaran_id' => $subject->id,
            'pesan'             => 'Tolong tinjau kembali nilainya.',
            'status'            => 'Pending',
        ]);
    }

    /**
     * Test teacher can view pending revision and resolve it.
     */
    public function test_teacher_can_view_revision_and_resolve_it(): void
    {
        $classroom = RuanganKelas::firstOrFail();
        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();

        // Create a pending revision request
        $revision = RevisiPenilaian::create([
            'ruangan_kelas_id'  => $classroom->id,
            'mata_pelajaran_id' => $subject->id,
            'pesan'             => 'Tolong diperbaiki.',
            'status'            => 'Pending',
        ]);

        // Teacher accesses grading sheet
        $response = $this->actingAs($this->teacherUser)
            ->get(route('dashboard.guru.penilaian.show', [
                'ruanganKelas'      => $classroom->id,
                'mata_pelajaran_id' => $subject->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('pendingRevisions');
        
        // Assert view contains the message
        $response->assertSee('Tolong diperbaiki.');

        // Teacher resolves the revision
        $resolveResponse = $this->actingAs($this->teacherUser)
            ->post(route('dashboard.guru.penilaian.revisi.resolve', $revision->id));

        $resolveResponse->assertRedirect();

        $this->assertDatabaseHas('revisi_penilaian', [
            'id'     => $revision->id,
            'status' => 'Selesai',
        ]);
    }
}
