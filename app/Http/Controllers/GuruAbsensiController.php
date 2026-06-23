<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\GuruAbsensiDataTable;
use App\Models\Absensi;
use App\Models\MataPelajaran;
use App\Models\RuanganKelas;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GuruAbsensiController extends Controller
{
    /**
     * Display a listing of classrooms where the teacher teaches.
     *
     * @param GuruAbsensiDataTable $dataTable
     */
    public function index(GuruAbsensiDataTable $dataTable)
    {
        return $dataTable->render('dashboard.guru.absensi.index');
    }

    /**
     * Show the attendance sheet for a specific classroom and subject.
     *
     * @param RuanganKelas $ruanganKelas
     * @param Request $request
     * @return View
     */
    public function showAbsensi(RuanganKelas $ruanganKelas, Request $request): View
    {
        $guruId = auth()->user()->guru->id ?? 0;

        // Ensure teacher is scheduled to teach in this classroom
        $isScheduled = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
            ->where('kelas_id', $ruanganKelas->kelas_id)
            ->where('rombel_id', $ruanganKelas->rombel_id)
            ->where('semester_id', $ruanganKelas->semester_id)
            ->exists();

        if (!$isScheduled) {
            abort(403, 'Anda tidak memiliki akses ke ruangan kelas ini.');
        }

        // Get subjects taught by the teacher in this classroom
        $subjects = MataPelajaran::whereHas('jadwalPelajaran', function ($query) use ($guruId, $ruanganKelas) {
            $query->where('guru_id', $guruId)
                ->where('kelas_id', $ruanganKelas->kelas_id)
                ->where('rombel_id', $ruanganKelas->rombel_id)
                ->where('semester_id', $ruanganKelas->semester_id);
        })->get();

        $selectedSubjectId = $request->get('mata_pelajaran_id') !== null ? (int)$request->get('mata_pelajaran_id') : ($subjects->first()?->id ?? null);
        $selectedDate = $request->get('tanggal', date('Y-m-d'));

        $rosterSheet = [];
        $attendanceSummary = collect();

        if ($selectedSubjectId !== null) {
            // Ensure teacher actually teaches this subject in this classroom
            if (!$subjects->pluck('id')->contains($selectedSubjectId)) {
                abort(403, 'Anda tidak mengajar mata pelajaran ini di ruangan kelas ini.');
            }

            // Get active students
            $students = Siswa::whereHas('anggotaKelas', function ($q) use ($ruanganKelas) {
                $q->where('ruangan_kelas_id', $ruanganKelas->id)
                  ->where('status', 'Aktif');
            })
            ->orderBy('nama_lengkap', 'asc')
            ->get();

            // Get existing attendance records
            $attendanceRecords = Absensi::where('ruangan_kelas_id', $ruanganKelas->id)
                ->where('mata_pelajaran_id', $selectedSubjectId)
                ->where('tanggal', $selectedDate)
                ->get()
                ->keyBy('siswa_id');

            foreach ($students as $student) {
                $rosterSheet[] = [
                    'siswa' => $student,
                    'attendance' => $attendanceRecords->get($student->id),
                ];
            }

            // Get attendance summary history for each student
            $attendanceSummary = Absensi::where('ruangan_kelas_id', $ruanganKelas->id)
                ->where('mata_pelajaran_id', $selectedSubjectId)
                ->select('siswa_id', 'status', DB::raw('count(*) as total'))
                ->groupBy('siswa_id', 'status')
                ->get()
                ->groupBy('siswa_id');
        }

        return view('dashboard.guru.absensi.absen', compact(
            'ruanganKelas',
            'subjects',
            'selectedSubjectId',
            'selectedDate',
            'rosterSheet',
            'attendanceSummary'
        ));
    }

    /**
     * Store student attendance records.
     *
     * @param RuanganKelas $ruanganKelas
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeAbsensi(RuanganKelas $ruanganKelas, Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal'              => ['required', 'date'],
            'mata_pelajaran_id'    => ['required', 'exists:mata_pelajaran,id'],
            'attendance'           => ['required', 'array'],
            'attendance.*.siswa_id' => ['required', 'exists:siswa,id'],
            'attendance.*.status'   => ['required', 'in:Hadir,Sakit,Izin,Alpa'],
            'attendance.*.keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $guruId = auth()->user()->guru->id ?? 0;
        $subjectId = (int)$request->input('mata_pelajaran_id');
        $tanggal = $request->input('tanggal');

        // Ensure teacher actually teaches this subject in this classroom
        $isScheduled = \App\Models\JadwalPelajaran::where('guru_id', $guruId)
            ->where('kelas_id', $ruanganKelas->kelas_id)
            ->where('rombel_id', $ruanganKelas->rombel_id)
            ->where('semester_id', $ruanganKelas->semester_id)
            ->where('mata_pelajaran_id', $subjectId)
            ->exists();

        if (!$isScheduled) {
            abort(403, 'Anda tidak mengajar mata pelajaran ini di ruangan kelas ini.');
        }

        DB::transaction(function () use ($ruanganKelas, $subjectId, $guruId, $tanggal, $request) {
            $attendanceData = $request->input('attendance', []);

            foreach ($attendanceData as $item) {
                Absensi::updateOrCreate(
                    [
                        'ruangan_kelas_id'  => $ruanganKelas->id,
                        'mata_pelajaran_id' => $subjectId,
                        'siswa_id'          => $item['siswa_id'],
                        'tanggal'           => $tanggal,
                    ],
                    [
                        'guru_id'    => $guruId,
                        'status'     => $item['status'],
                        'keterangan' => $item['keterangan'] ?? null,
                    ]
                );
            }
        });

        flash()->success('Data absensi berhasil disimpan!');

        return redirect()->route('dashboard.guru.absensi.show', [
            'ruanganKelas'      => $ruanganKelas->id,
            'tanggal'           => $tanggal,
            'mata_pelajaran_id' => $subjectId
        ]);
    }
}
