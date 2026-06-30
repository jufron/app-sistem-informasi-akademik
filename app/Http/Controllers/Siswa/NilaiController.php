<?php

declare(strict_types=1);

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\RuanganKelas;
use App\Models\AnggotaKelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class NilaiController
 *
 * Coordinates student portal requests to view their class history, subject scores, and attendance data.
 */
class NilaiController extends Controller
{
    /**
     * Display a listing of the class history for the authenticated student.
     *
     * @return View
     */
    public function index(): View
    {
        $siswa = Siswa::where('user_id', auth()->id())->firstOrFail();

        // Get class history list
        $anggotaKelasList = AnggotaKelas::with([
            'ruanganKelas.kelas',
            'ruanganKelas.rombel',
            'ruanganKelas.guru',
            'ruanganKelas.semester'
        ])
        ->where('siswa_id', $siswa->id)
        ->get();

        // Group by class & academic year to show distinct academic years enrolled
        $classHistory = $anggotaKelasList->groupBy(function ($item) {
            return $item->ruanganKelas->kelas_id . '-' . $item->ruanganKelas->tahun_ajaran;
        })->map(function ($group) {
            $first = $group->first();
            $semesters = $group->map(function ($item) {
                return $item->ruanganKelas->semester->nama;
            })->unique()->sort()->implode(' & ');

            return [
                'kelas' => $first->ruanganKelas->kelas,
                'rombel' => $first->ruanganKelas->rombel,
                'guru' => $first->ruanganKelas->guru,
                'tahun_angkatan' => $first->ruanganKelas->tahun_angkatan,
                'tahun_ajaran' => $first->ruanganKelas->tahun_ajaran,
                'status' => $first->status,
                'ruangan_kelas_id' => $first->ruangan_kelas_id,
                'semesters' => $semesters,
            ];
        });

        return view('dashboard.siswa.nilai.index', compact('siswa', 'classHistory'));
    }

    /**
     * Display the student profile details, subject scores, and attendance grouped by semesters.
     *
     * @param RuanganKelas $ruanganKelas Bound classroom instance
     * @return View
     */
    public function show(RuanganKelas $ruanganKelas): View
    {
        $siswa = Siswa::with(['user', 'jenisKelamin', 'agama'])->where('user_id', auth()->id())->firstOrFail();

        // Security: Ensure the student actually belongs to this classroom group
        $hasAccess = AnggotaKelas::where('siswa_id', $siswa->id)
            ->whereHas('ruanganKelas', function ($query) use ($ruanganKelas) {
                $query->where('kelas_id', $ruanganKelas->kelas_id)
                    ->where('rombel_id', $ruanganKelas->rombel_id)
                    ->where('tahun_ajaran', $ruanganKelas->tahun_ajaran);
            })
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses untuk melihat hasil nilai ini.');
        }

        // Get all classrooms sharing the same class, rombel, and academic year (typically representing Semesters)
        $classrooms = RuanganKelas::with('semester')
            ->where('kelas_id', $ruanganKelas->kelas_id)
            ->where('rombel_id', $ruanganKelas->rombel_id)
            ->where('tahun_ajaran', $ruanganKelas->tahun_ajaran)
            ->orderBy('semester_id', 'asc')
            ->get();

        $semesterData = [];

        foreach ($classrooms as $classroom) {
            // Retrieve all subjects scheduled in this classroom for the semester
            $subjects = MataPelajaran::whereHas('jadwalPelajaran', function ($query) use ($classroom) {
                $query->where('kelas_id', $classroom->kelas_id)
                    ->where('rombel_id', $classroom->rombel_id)
                    ->where('semester_id', $classroom->semester_id);
            })->get();

            // Fetch student's grades mapped by subject ID
            $nilaiMap = Nilai::where('siswa_id', $siswa->id)
                ->where('ruangan_kelas_id', $classroom->id)
                ->get()
                ->keyBy('mata_pelajaran_id');

            $gradesSheet = [];
            foreach ($subjects as $subject) {
                $nilai = $nilaiMap->get($subject->id);
                $gradesSheet[] = [
                    'subject' => $subject,
                    'nilai'   => $nilai,
                    'grade'   => $this->calculateLetterGrade($nilai?->nilai_akhir),
                ];
            }

            // Fetch student's attendance records in this classroom
            $attendance = Absensi::with('mataPelajaran')
                ->where('siswa_id', $siswa->id)
                ->where('ruangan_kelas_id', $classroom->id)
                ->orderBy('tanggal', 'desc')
                ->get();

            $absensiSummary = [
                'Hadir' => $attendance->where('status', 'Hadir')->count(),
                'Sakit' => $attendance->where('status', 'Sakit')->count(),
                'Izin'  => $attendance->where('status', 'Izin')->count(),
                'Alpa'  => $attendance->where('status', 'Alpa')->count(),
            ];

            $semesterData[] = [
                'classroom'         => $classroom,
                'semester_name'     => $classroom->semester->nama,
                'gradesSheet'       => $gradesSheet,
                'absensiSummary'    => $absensiSummary,
                'attendanceHistory' => $attendance->whereIn('status', ['Sakit', 'Izin', 'Alpa']),
            ];
        }

        return view('dashboard.siswa.nilai.show', compact('siswa', 'ruanganKelas', 'semesterData'));
    }

    /**
     * Determine letter grade based on final numerical score.
     *
     * @param float|null $nilaiAkhir Final numerical score
     * @return string Letter grade or dash
     */
    protected function calculateLetterGrade(?float $nilaiAkhir): string
    {
        if ($nilaiAkhir === null) {
            return '-';
        }
        if ($nilaiAkhir >= 85) {
            return 'A';
        }
        if ($nilaiAkhir >= 75) {
            return 'B';
        }
        if ($nilaiAkhir >= 65) {
            return 'C';
        }
        if ($nilaiAkhir >= 50) {
            return 'D';
        }
        return 'E';
    }
}
