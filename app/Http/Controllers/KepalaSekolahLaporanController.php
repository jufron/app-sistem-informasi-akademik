<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\RuanganKelas;
use App\Models\MataPelajaran;
use App\Repositories\Interfaces\NilaiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KepalaSekolahLaporanController extends Controller
{
    /**
     * Display reporting dashboard.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $students = Siswa::with(['jenisKelamin', 'agama'])->orderBy('nama_lengkap', 'asc')->get();
        $teachers = Guru::with(['jenisKelamin', 'agama', 'mataPelajaran'])->orderBy('nama_lengkap', 'asc')->get();
        $classrooms = RuanganKelas::with(['kelas', 'rombel', 'semester', 'guru'])->latest()->get();
        $subjects = MataPelajaran::orderBy('nama', 'asc')->get();

        $selectedClassroomId = $request->get('ruangan_kelas_id') !== null ? (int)$request->get('ruangan_kelas_id') : null;
        $selectedSubjectId = $request->get('mata_pelajaran_id') !== null ? (int)$request->get('mata_pelajaran_id') : null;
        
        $assessmentSubjects = collect();
        $gradesSheet = [];

        if ($selectedClassroomId) {
            $classroom = RuanganKelas::find($selectedClassroomId);
            if ($classroom) {
                $assessmentSubjects = MataPelajaran::whereHas('jadwalPelajaran', function ($query) use ($classroom) {
                    $query->where('kelas_id', $classroom->kelas_id)
                        ->where('rombel_id', $classroom->rombel_id)
                        ->where('semester_id', $classroom->semester_id);
                })->get();

                if ($selectedSubjectId && $assessmentSubjects->pluck('id')->contains($selectedSubjectId)) {
                    $activeStudents = Siswa::whereHas('anggotaKelas', function ($q) use ($selectedClassroomId) {
                        $q->where('ruangan_kelas_id', $selectedClassroomId)
                          ->where('status', 'Aktif');
                    })
                    ->orderBy('nama_lengkap', 'asc')
                    ->get();

                    $nilaiRepo = app(NilaiRepositoryInterface::class);
                    $grades = $nilaiRepo->getGrades($selectedClassroomId, $selectedSubjectId)->keyBy('siswa_id');

                    foreach ($activeStudents as $student) {
                        $gradesSheet[] = [
                            'siswa' => $student,
                            'nilai' => $grades->get($student->id),
                        ];
                    }
                }
            }
        }

        return view('dashboard.kepala-sekolah.laporan.index', compact(
            'students',
            'teachers',
            'classrooms',
            'subjects',
            'selectedClassroomId',
            'selectedSubjectId',
            'assessmentSubjects',
            'gradesSheet'
        ));
    }

    /**
     * Print Student Report.
     */
    public function printSiswa(): View
    {
        $students = Siswa::with(['jenisKelamin', 'agama'])->orderBy('nama_lengkap', 'asc')->get();
        return view('dashboard.kepala-sekolah.laporan.print-siswa', compact('students'));
    }

    /**
     * Print Teacher Report.
     */
    public function printGuru(): View
    {
        $teachers = Guru::with(['jenisKelamin', 'agama', 'mataPelajaran'])->orderBy('nama_lengkap', 'asc')->get();
        return view('dashboard.kepala-sekolah.laporan.print-guru', compact('teachers'));
    }

    /**
     * Print Classroom Report.
     */
    public function printKelas(): View
    {
        $classrooms = RuanganKelas::with(['kelas', 'rombel', 'semester', 'guru', 'anggotaKelas'])->latest()->get();
        return view('dashboard.kepala-sekolah.laporan.print-kelas', compact('classrooms'));
    }

    /**
     * Print Subject Report.
     */
    public function printMapel(): View
    {
        $subjects = MataPelajaran::orderBy('nama', 'asc')->get();
        return view('dashboard.kepala-sekolah.laporan.print-mapel', compact('subjects'));
    }

    /**
     * Print Grades Report.
     */
    public function printPenilaian(Request $request): View
    {
        $request->validate([
            'ruangan_kelas_id'  => ['required', 'exists:ruangan_kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
        ]);

        $classroom = RuanganKelas::with(['kelas', 'rombel', 'semester', 'guru'])->findOrFail($request->ruangan_kelas_id);
        $subject = MataPelajaran::findOrFail($request->mata_pelajaran_id);

        $activeStudents = Siswa::whereHas('anggotaKelas', function ($q) use ($classroom) {
            $q->where('ruangan_kelas_id', $classroom->id)
              ->where('status', 'Aktif');
        })
        ->orderBy('nama_lengkap', 'asc')
        ->get();

        $nilaiRepo = app(NilaiRepositoryInterface::class);
        $grades = $nilaiRepo->getGrades($classroom->id, $subject->id)->keyBy('siswa_id');

        $gradesSheet = [];
        foreach ($activeStudents as $student) {
            $gradesSheet[] = [
                'siswa' => $student,
                'nilai' => $grades->get($student->id),
            ];
        }

        return view('dashboard.kepala-sekolah.laporan.print-penilaian', compact(
            'classroom',
            'subject',
            'gradesSheet'
        ));
    }
}
