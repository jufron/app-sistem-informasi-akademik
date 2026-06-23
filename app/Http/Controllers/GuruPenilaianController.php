<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTables\GuruPenilaianDataTable;
use App\Http\Requests\SaveNilaiRequest;
use App\Models\RuanganKelas;
use App\Services\Interfaces\NilaiServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuruPenilaianController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param NilaiServiceInterface $nilaiService
     */
    public function __construct(
        protected NilaiServiceInterface $nilaiService
    ) {}

    /**
     * Display a listing of classrooms where the teacher teaches.
     *
     * @param GuruPenilaianDataTable $dataTable
     */
    public function index(GuruPenilaianDataTable $dataTable)
    {
        return $dataTable->render('dashboard.guru.penilaian.index');
    }

    /**
     * Show the grading sheet for a specific classroom and subject.
     *
     * @param RuanganKelas $ruanganKelas
     * @param Request $request
     * @return View
     */
    public function showGrades(RuanganKelas $ruanganKelas, Request $request): View
    {
        $guruId = auth()->user()->guru->id ?? 0;

        // Ensure teacher is scheduled to teach in this classroom
        $allowedClassrooms = $this->nilaiService->getClassroomsForTeacher($guruId)->pluck('id');
        if (!$allowedClassrooms->contains($ruanganKelas->id)) {
            abort(403, 'Anda tidak memiliki akses ke ruangan kelas ini.');
        }

        // Get subjects taught by the teacher in this classroom
        $subjects = $this->nilaiService->getSubjectsForTeacherInClassroom($guruId, $ruanganKelas->id);

        $selectedSubjectId = $request->get('mata_pelajaran_id') !== null ? (int)$request->get('mata_pelajaran_id') : null;
        $gradesSheet = [];
        $pendingRevisions = collect();
        $allRevisions = collect();

        if ($selectedSubjectId !== null) {
            // Ensure teacher actually teaches this subject in this classroom
            if (!$subjects->pluck('id')->contains($selectedSubjectId)) {
                abort(403, 'Anda tidak mengajar mata pelajaran ini di ruangan kelas ini.');
            }
            $gradesSheet = $this->nilaiService->getGradesSheet($ruanganKelas->id, $selectedSubjectId);

            // Fetch pending revisions for this classroom and subject
            $pendingRevisions = \App\Models\RevisiPenilaian::where('ruangan_kelas_id', $ruanganKelas->id)
                ->where('mata_pelajaran_id', $selectedSubjectId)
                ->where('status', 'Pending')
                ->get();

            // Fetch all revisions history for this classroom and subject
            $allRevisions = \App\Models\RevisiPenilaian::where('ruangan_kelas_id', $ruanganKelas->id)
                ->where('mata_pelajaran_id', $selectedSubjectId)
                ->latest()
                ->get();
        }

        return view('dashboard.guru.penilaian.grade', compact(
            'ruanganKelas',
            'subjects',
            'selectedSubjectId',
            'gradesSheet',
            'pendingRevisions',
            'allRevisions'
        ));
    }

    /**
     * Resolve/clear a grade revision request.
     *
     * @param \App\Models\RevisiPenilaian $revisi
     * @return RedirectResponse
     */
    public function resolveRevisi(\App\Models\RevisiPenilaian $revisi): RedirectResponse
    {
        $revisi->update(['status' => 'Selesai']);
        flash()->success('Revisi berhasil ditandai selesai.');
        return redirect()->back();
    }

    /**
     * Save/update student grades bulk input.
     *
     * @param SaveNilaiRequest $request
     * @param RuanganKelas $ruanganKelas
     * @return RedirectResponse
     */
    public function storeGrades(SaveNilaiRequest $request, RuanganKelas $ruanganKelas): RedirectResponse
    {
        $guruId = auth()->user()->guru->id ?? 0;

        // Ensure teacher is scheduled in this classroom
        $allowedClassrooms = $this->nilaiService->getClassroomsForTeacher($guruId)->pluck('id');
        if (!$allowedClassrooms->contains($ruanganKelas->id)) {
            abort(403, 'Anda tidak memiliki akses ke ruangan kelas ini.');
        }

        $subjectId = (int)$request->input('mata_pelajaran_id');
        $subjects = $this->nilaiService->getSubjectsForTeacherInClassroom($guruId, $ruanganKelas->id);

        // Ensure teacher teaches this subject in this classroom
        if (!$subjects->pluck('id')->contains($subjectId)) {
            abort(403, 'Anda tidak mengajar mata pelajaran ini di ruangan kelas ini.');
        }

        $this->nilaiService->saveGrades(
            $ruanganKelas->id,
            $subjectId,
            $guruId,
            $request->input('grades')
        );

        flash()->success('Nilai berhasil disimpan!');

        return redirect()->route('dashboard.guru.penilaian.show', [
            'ruanganKelas'      => $ruanganKelas->id,
            'mata_pelajaran_id' => $subjectId
        ]);
    }
}
