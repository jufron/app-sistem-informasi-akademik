<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MataPelajaran;
use App\Models\RuanganKelas;
use App\Models\Siswa;
use App\Repositories\Interfaces\NilaiRepositoryInterface;
use App\Services\Interfaces\NilaiServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class NilaiService
 * 
 * Handles database transaction encapsulation, dynamic scheduler queries, and grading sheets.
 */
class NilaiService implements NilaiServiceInterface
{
    /**
     * Create a new service instance.
     *
     * @param NilaiRepositoryInterface $nilaiRepo
     */
    public function __construct(
        protected NilaiRepositoryInterface $nilaiRepo
    ) {}

    /**
     * Retrieve classrooms where the teacher is scheduled to teach.
     *
     * @param int|string $guruId
     * @return Collection<int, RuanganKelas>
     */
    public function getClassroomsForTeacher(int|string $guruId): Collection
    {
        return RuanganKelas::whereExists(function ($query) use ($guruId) {
            $query->select(DB::raw(1))
                ->from('jadwal_pelajaran')
                ->whereColumn('jadwal_pelajaran.kelas_id', 'ruangan_kelas.kelas_id')
                ->whereColumn('jadwal_pelajaran.rombel_id', 'ruangan_kelas.rombel_id')
                ->whereColumn('jadwal_pelajaran.semester_id', 'ruangan_kelas.semester_id')
                ->where('jadwal_pelajaran.guru_id', $guruId);
        })
        ->with(['kelas', 'rombel', 'semester', 'guru'])
        ->get();
    }

    /**
     * Retrieve subjects taught by the teacher in a specific classroom.
     *
     * @param int|string $guruId
     * @param int|string $ruanganKelasId
     * @return Collection
     */
    public function getSubjectsForTeacherInClassroom(int|string $guruId, int|string $ruanganKelasId): Collection
    {
        $classroom = RuanganKelas::findOrFail($ruanganKelasId);

        return MataPelajaran::whereHas('jadwalPelajaran', function ($query) use ($guruId, $classroom) {
            $query->where('guru_id', $guruId)
                ->where('kelas_id', $classroom->kelas_id)
                ->where('rombel_id', $classroom->rombel_id)
                ->where('semester_id', $classroom->semester_id);
        })->get();
    }

    /**
     * Get the student list and their grades for a classroom and subject.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $mataPelajaranId
     * @return array
     */
    public function getGradesSheet(int|string $ruanganKelasId, int|string $mataPelajaranId): array
    {
        // Get all active students registered in this classroom
        $students = Siswa::whereHas('anggotaKelas', function ($q) use ($ruanganKelasId) {
            $q->where('ruangan_kelas_id', $ruanganKelasId)
              ->where('status', 'Aktif');
        })
        ->orderBy('nama_lengkap', 'asc')
        ->get();

        // Get existing grades mapped by siswa_id
        $grades = $this->nilaiRepo->getGrades($ruanganKelasId, $mataPelajaranId)->keyBy('siswa_id');

        $gradesSheet = [];
        foreach ($students as $student) {
            $gradesSheet[] = [
                'siswa' => $student,
                'nilai' => $grades->get($student->id),
            ];
        }

        return $gradesSheet;
    }

    /**
     * Save student grades for a specific classroom and subject.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $mataPelajaranId
     * @param int|string $guruId
     * @param array $gradesData
     * @return void
     */
    public function saveGrades(int|string $ruanganKelasId, int|string $mataPelajaranId, int|string $guruId, array $gradesData): void
    {
        DB::transaction(function () use ($ruanganKelasId, $mataPelajaranId, $guruId, $gradesData) {
            foreach ($gradesData as $gradeItem) {
                $siswaId = $gradeItem['siswa_id'];
                
                $attributes = [
                    'siswa_id'          => $siswaId,
                    'ruangan_kelas_id'  => $ruanganKelasId,
                    'mata_pelajaran_id' => $mataPelajaranId,
                ];

                $values = [
                    'guru_id'              => $guruId,
                    'nilai_formatif'       => isset($gradeItem['nilai_formatif']) && $gradeItem['nilai_formatif'] !== '' ? (float)$gradeItem['nilai_formatif'] : null,
                    'nilai_sumatif_materi' => isset($gradeItem['nilai_sumatif_materi']) && $gradeItem['nilai_sumatif_materi'] !== '' ? (float)$gradeItem['nilai_sumatif_materi'] : null,
                    'nilai_sumatif_akhir'  => isset($gradeItem['nilai_sumatif_akhir']) && $gradeItem['nilai_sumatif_akhir'] !== '' ? (float)$gradeItem['nilai_sumatif_akhir'] : null,
                    'keterangan'           => $gradeItem['keterangan'] ?? null,
                ];

                $this->nilaiRepo->updateOrCreateGrade($attributes, $values);
            }
        });
    }
}
