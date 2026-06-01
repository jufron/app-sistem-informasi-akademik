<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Http\Requests\StoreJadwalPelajaranRequest;
use App\Http\Requests\UpdateJadwalPelajaranRequest;
use App\DataTables\JadwalPelajaranDataTable;
use App\Services\Interfaces\JadwalPelajaranServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPelajaranController extends Controller
{
    protected JadwalPelajaranServiceInterface $jadwalPelajaranService;

    public function __construct(JadwalPelajaranServiceInterface $jadwalPelajaranService)
    {
        $this->jadwalPelajaranService = $jadwalPelajaranService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(JadwalPelajaranDataTable $dataTable)
    {
        $kelasList = \App\Models\Kelas::all();
        $rombelList = \App\Models\Rombel::all();
        $semesterList = \App\Models\Semester::all();
        return $dataTable->render('dashboard.admin.jadwal-pelajaran.index', compact('kelasList', 'rombelList', 'semesterList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelasList = \App\Models\Kelas::all();
        $rombelList = \App\Models\Rombel::all();
        $semesterList = \App\Models\Semester::all();

        return view('dashboard.admin.jadwal-pelajaran.create', compact('gurus', 'mataPelajarans', 'kelasList', 'rombelList', 'semesterList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJadwalPelajaranRequest $request): RedirectResponse
    {
        $this->jadwalPelajaranService->store($request->validated());

        flash()->success('Data Jadwal Pelajaran berhasil ditambahkan!');
        return redirect()->route('dashboard.jadwal-pelajaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalPelajaran $jadwalPelajaran): JsonResponse
    {
        $jadwalPelajaran->load(['guru', 'mataPelajaran', 'kelas', 'rombel', 'semester']);
        return response()->json($jadwalPelajaran);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPelajaran $jadwalPelajaran): View
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        $kelasList = \App\Models\Kelas::all();
        $rombelList = \App\Models\Rombel::all();
        $semesterList = \App\Models\Semester::all();
        $jadwalPelajaran->load(['guru', 'mataPelajaran', 'kelas', 'rombel', 'semester']);

        return view('dashboard.admin.jadwal-pelajaran.edit', compact('jadwalPelajaran', 'gurus', 'mataPelajarans', 'kelasList', 'rombelList', 'semesterList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJadwalPelajaranRequest $request, JadwalPelajaran $jadwalPelajaran): RedirectResponse
    {
        $this->jadwalPelajaranService->update($jadwalPelajaran, $request->validated());

        flash()->success('Data Jadwal Pelajaran berhasil diperbarui!');
        return redirect()->route('dashboard.jadwal-pelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPelajaran $jadwalPelajaran): RedirectResponse
    {
        $this->jadwalPelajaranService->destroy($jadwalPelajaran);

        flash()->success('Data Jadwal Pelajaran berhasil dihapus!');
        return redirect()->route('dashboard.jadwal-pelajaran.index');
    }

    /**
     * Remove the specified resources from storage in bulk.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = (array) $request->input('ids', []);

        if ($this->jadwalPelajaranService->bulkDestroy($ids)) {
            flash()->success('Berhasil Menghapus Data Terpilih');
        } else {
            flash()->error('Pilih data terlebih dahulu');
        }

        return redirect()->route('dashboard.jadwal-pelajaran.index');
    }

    /**
     * Get JSON events for FullCalendar view.
     */
    public function events(): JsonResponse
    {
        $events = $this->jadwalPelajaranService->getEventsForCalendar();
        return response()->json($events);
    }
}

