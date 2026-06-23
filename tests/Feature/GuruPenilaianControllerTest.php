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
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Nilai;
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

class GuruPenilaianControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $teacherUser;
    protected User $otherUser;

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
            RuanganKelasSeeder::class,
            JadwalPelajaranSeeder::class,
            SiswaSeeder::class,
            AnggotaKelasSeeder::class,
        ]);

        // Get seeded teacher user (Antonius Budi teaches Matematika in Kelas 1 Rombel A Semester 1)
        $this->teacherUser = User::where('email', 'antonius@mail.com')->firstOrFail();

        // Create standard user with no "guru" role
        $this->otherUser = User::factory()->create();
    }

    /**
     * Test guest cannot access.
     */
    public function test_guest_cannot_access_penilaian(): void
    {
        $response = $this->get(route('dashboard.guru.penilaian.index'));
        $response->assertRedirect('/login');
    }

    /**
     * Test non-teacher cannot access.
     */
    public function test_non_teacher_cannot_access_penilaian(): void
    {
        $response = $this->actingAs($this->otherUser)->get(route('dashboard.guru.penilaian.index'));
        $response->assertStatus(403);
    }

    /**
     * Test teacher can view index.
     */
    public function test_teacher_can_view_penilaian_index(): void
    {
        $response = $this->actingAs($this->teacherUser)->get(route('dashboard.guru.penilaian.index'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.penilaian.index');
    }

    /**
     * Test teacher can view grades sheet for assigned classroom.
     */
    public function test_teacher_can_view_grades_sheet(): void
    {
        // Find Anton's classroom (Kelas 1-A)
        $classroom = RuanganKelas::whereHas('kelas', function ($q) {
            $q->where('nama', 'Kelas 1');
        })->firstOrFail();

        // Get Matematika subject ID
        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();

        $response = $this->actingAs($this->teacherUser)
            ->get(route('dashboard.guru.penilaian.show', [
                'ruanganKelas'      => $classroom->id,
                'mata_pelajaran_id' => $subject->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.penilaian.grade');
        $response->assertViewHasAll(['ruanganKelas', 'subjects', 'selectedSubjectId', 'gradesSheet']);
    }

    /**
     * Test teacher cannot view grades sheet for unassigned classroom.
     */
    public function test_teacher_cannot_view_unassigned_classroom_grades_sheet(): void
    {
        // Get Semester 2 ID
        $semester2 = Semester::where('nama', 'like', '%Semester 2%')->firstOrFail();

        // Create a classroom that Anton (teacherUser) does not teach in
        $unassignedClassroom = RuanganKelas::create([
            'kelas_id'       => Kelas::first()->id,
            'rombel_id'      => Rombel::first()->id,
            'semester_id'    => $semester2->id,
            'guru_id'        => Guru::where('nama_lengkap', 'like', '%Maria%')->firstOrFail()->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran'   => '2023/2024',
            'aktif'          => true,
        ]);

        $response = $this->actingAs($this->teacherUser)
            ->get(route('dashboard.guru.penilaian.show', $unassignedClassroom->id));

        $response->assertStatus(403);
    }

    /**
     * Test saving grades calculates final score correctly and persists them.
     */
    public function test_teacher_can_save_grades_successfully(): void
    {
        $classroom = RuanganKelas::whereHas('kelas', function ($q) {
            $q->where('nama', 'Kelas 1');
        })->firstOrFail();

        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();
        
        // Find students in this classroom
        $siswa = Siswa::whereHas('anggotaKelas', function ($q) use ($classroom) {
            $q->where('ruangan_kelas_id', $classroom->id);
        })->firstOrFail();

        $postData = [
            'mata_pelajaran_id' => $subject->id,
            'grades' => [
                [
                    'siswa_id'             => $siswa->id,
                    'nilai_formatif'       => 85.00,
                    'nilai_sumatif_materi' => 80.00,
                    'nilai_sumatif_akhir'  => 90.00,
                    'keterangan'           => 'Sangat baik dalam memahami Matematika dasar.',
                ]
            ]
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route('dashboard.guru.penilaian.store', $classroom->id), $postData);

        $response->assertRedirect(route('dashboard.guru.penilaian.show', [
            'ruanganKelas'      => $classroom->id,
            'mata_pelajaran_id' => $subject->id
        ]));

        // Assert database has record with average final score (80 + 90) / 2 = 85.00
        $this->assertDatabaseHas('nilai', [
            'siswa_id'             => $siswa->id,
            'ruangan_kelas_id'     => $classroom->id,
            'mata_pelajaran_id'    => $subject->id,
            'nilai_formatif'       => 85.00,
            'nilai_sumatif_materi' => 80.00,
            'nilai_sumatif_akhir'  => 90.00,
            'nilai_akhir'          => 85.00,
            'keterangan'           => 'Sangat baik dalam memahami Matematika dasar.',
        ]);
    }

    /**
     * Test validation ranges of grades.
     */
    public function test_saving_invalid_grades_fails(): void
    {
        $classroom = RuanganKelas::whereHas('kelas', function ($q) {
            $q->where('nama', 'Kelas 1');
        })->firstOrFail();

        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();
        
        $siswa = Siswa::whereHas('anggotaKelas', function ($q) use ($classroom) {
            $q->where('ruangan_kelas_id', $classroom->id);
        })->firstOrFail();

        $postData = [
            'mata_pelajaran_id' => $subject->id,
            'grades' => [
                [
                    'siswa_id'             => $siswa->id,
                    'nilai_formatif'       => 150.00, // Invalid: exceeds max 100
                    'nilai_sumatif_materi' => 80.00,
                    'nilai_sumatif_akhir'  => -5.00,  // Invalid: below min 0
                    'keterangan'           => 'Invalid grades',
                ]
            ]
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route('dashboard.guru.penilaian.store', $classroom->id), $postData);

        $response->assertSessionHasErrors([
            'grades.0.nilai_formatif',
            'grades.0.nilai_sumatif_akhir'
        ]);
    }
}
