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
use App\Models\Absensi;
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

class GuruAbsensiTest extends TestCase
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
    public function test_guest_cannot_access_absensi(): void
    {
        $response = $this->get(route('dashboard.guru.absensi.index'));
        $response->assertRedirect('/login');
    }

    /**
     * Test non-teacher cannot access.
     */
    public function test_non_teacher_cannot_access_absensi(): void
    {
        $response = $this->actingAs($this->otherUser)->get(route('dashboard.guru.absensi.index'));
        $response->assertStatus(403);
    }

    /**
     * Test teacher can view index.
     */
    public function test_teacher_can_view_absensi_index(): void
    {
        $response = $this->actingAs($this->teacherUser)->get(route('dashboard.guru.absensi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.absensi.index');
    }

    /**
     * Test teacher can view attendance sheet for assigned classroom.
     */
    public function test_teacher_can_view_absensi_sheet(): void
    {
        // Find Anton's classroom (Kelas 1-A)
        $classroom = RuanganKelas::whereHas('kelas', function ($q) {
            $q->where('nama', 'Kelas 1');
        })->firstOrFail();

        // Get Matematika subject
        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();

        $response = $this->actingAs($this->teacherUser)
            ->get(route('dashboard.guru.absensi.show', [
                'ruanganKelas'      => $classroom->id,
                'mata_pelajaran_id' => $subject->id,
                'tanggal'           => '2026-06-23'
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.absensi.absen');
        $response->assertViewHasAll(['ruanganKelas', 'subjects', 'selectedSubjectId', 'selectedDate', 'rosterSheet', 'attendanceSummary']);
    }

    /**
     * Test teacher cannot view attendance sheet for unassigned classroom.
     */
    public function test_teacher_cannot_view_unassigned_classroom_absensi_sheet(): void
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
            ->get(route('dashboard.guru.absensi.show', $unassignedClassroom->id));

        $response->assertStatus(403);
    }

    /**
     * Test saving attendance persists records correctly.
     */
    public function test_teacher_can_save_attendance_successfully(): void
    {
        $classroom = RuanganKelas::whereHas('kelas', function ($q) {
            $q->where('nama', 'Kelas 1');
        })->firstOrFail();

        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();
        
        // Find student in this classroom
        $siswa = Siswa::whereHas('anggotaKelas', function ($q) use ($classroom) {
            $q->where('ruangan_kelas_id', $classroom->id);
        })->firstOrFail();

        $postData = [
            'tanggal'           => '2026-06-23',
            'mata_pelajaran_id' => $subject->id,
            'attendance' => [
                [
                    'siswa_id'   => $siswa->id,
                    'status'     => 'Sakit',
                    'keterangan' => 'Demam tinggi.',
                ]
            ]
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route('dashboard.guru.absensi.store', $classroom->id), $postData);

        $response->assertRedirect(route('dashboard.guru.absensi.show', [
            'ruanganKelas'      => $classroom->id,
            'tanggal'           => '2026-06-23',
            'mata_pelajaran_id' => $subject->id
        ]));

        // Assert database has record
        $this->assertDatabaseHas('absensi', [
            'siswa_id'          => $siswa->id,
            'ruangan_kelas_id'  => $classroom->id,
            'mata_pelajaran_id' => $subject->id,
            'tanggal'           => '2026-06-23',
            'status'            => 'Sakit',
            'keterangan'        => 'Demam tinggi.',
        ]);
    }

    /**
     * Test attendance validation ranges and incorrect status.
     */
    public function test_saving_invalid_attendance_fails(): void
    {
        $classroom = RuanganKelas::whereHas('kelas', function ($q) {
            $q->where('nama', 'Kelas 1');
        })->firstOrFail();

        $subject = MataPelajaran::where('nama', 'Matematika')->firstOrFail();
        
        $siswa = Siswa::whereHas('anggotaKelas', function ($q) use ($classroom) {
            $q->where('ruangan_kelas_id', $classroom->id);
        })->firstOrFail();

        $postData = [
            'tanggal'           => 'invalid-date',
            'mata_pelajaran_id' => $subject->id,
            'attendance' => [
                [
                    'siswa_id'   => $siswa->id,
                    'status'     => 'Bolos', // Invalid status: must be Hadir, Sakit, Izin, Alpa
                    'keterangan' => 'Kabur',
                ]
            ]
        ];

        $response = $this->actingAs($this->teacherUser)
            ->post(route('dashboard.guru.absensi.store', $classroom->id), $postData);

        $response->assertSessionHasErrors([
            'tanggal',
            'attendance.0.status'
        ]);
    }
}
