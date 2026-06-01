<?php

namespace App\Http\Controllers;

use App\DataTables\RuanganKelasDataTable;
use App\Http\Requests\RuanganKelasStoreRequest;
use App\Http\Requests\RuanganKelasUpdateRequest;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\RuanganKelas;
use App\Models\Semester;
use App\Models\Siswa;
use App\Services\Interfaces\RuanganKelasServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class RuanganKelasController extends Controller
{
    /**
     * The service instance.
     */
    protected RuanganKelasServiceInterface $ruanganKelasService;

    /**
     * Create a new controller instance.
     */
    public function __construct(RuanganKelasServiceInterface $ruanganKelasService)
    {
        $this->ruanganKelasService = $ruanganKelasService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(RuanganKelasDataTable $dataTable)
    {
        $kelas = Kelas::all();
        $rombel = Rombel::all();
        $semester = Semester::all();

        return $dataTable->render('dashboard.admin.ruangan-kelas.index', compact('kelas', 'rombel', 'semester'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kelas = Kelas::all();
        $rombel = Rombel::all();
        $semester = Semester::all();
        $guru = Guru::all();
        $siswa = Siswa::where('status', 'Aktif')->get();

        return view('dashboard.admin.ruangan-kelas.tambah', compact('kelas', 'rombel', 'semester', 'guru', 'siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RuanganKelasStoreRequest $request): RedirectResponse
    {
        $this->ruanganKelasService->store($request->validated());
        flash()->success('Data berhasil ditambahkan!');

        return redirect()->route('dashboard.ruangan-kelas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RuanganKelas $ruanganKelas): JsonResponse
    {
        return response()->json($ruanganKelas->load(['kelas', 'rombel', 'semester', 'guru', 'anggotaKelas.siswa']));
    }

    /**
     * Export class detail and student list to PDF.
     */
    public function pdf(RuanganKelas $ruanganKelas): PdfBuilder
    {
        $ruanganKelas->load(['kelas', 'rombel', 'semester', 'guru', 'anggotaKelas.siswa']);

        // Generate filename dynamically: kelas-rombel-semester-tahun_angkatan-tahun_ajaran
        $kelas = $ruanganKelas->kelas ? $ruanganKelas->kelas->nama : 'Unknown';
        $rombel = $ruanganKelas->rombel ? $ruanganKelas->rombel->nama : 'Unknown';
        $semester = $ruanganKelas->semester ? $ruanganKelas->semester->nama : 'Unknown';
        $angkatan = $ruanganKelas->tahun_angkatan ?? 'Unknown';
        $ajaran = $ruanganKelas->tahun_ajaran ?? 'Unknown';

        // Sanitize filename parts to remove spaces and slashes
        $sanitizedParts = array_map(function ($part) {
            $part = str_replace([' ', '/', '\\'], ['_', '_', '_'], $part);

            return preg_replace('/[^A-Za-z0-9_\-]/', '', $part);
        }, [$kelas, $rombel, $semester, $angkatan, $ajaran]);

        $filename = implode('-', $sanitizedParts).'.pdf';

        return Pdf::view('dashboard.admin.ruangan-kelas.pdf', compact('ruanganKelas'))
            ->download($filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RuanganKelas $ruanganKelas): View
    {
        $kelas = Kelas::all();
        $rombel = Rombel::all();
        $semester = Semester::all();
        $guru = Guru::all();
        
        // Retrieve active students or students that are already registered as members of this classroom
        $siswa = \App\Models\Siswa::where('status', 'Aktif')
            ->orWhereIn('id', $ruanganKelas->anggotaKelas->pluck('siswa_id'))
            ->get();

        return view('dashboard.admin.ruangan-kelas.ubah', compact('ruanganKelas', 'kelas', 'rombel', 'semester', 'guru', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RuanganKelasUpdateRequest $request, RuanganKelas $ruanganKelas): RedirectResponse
    {
        $this->ruanganKelasService->update($ruanganKelas, $request->validated());
        flash()->success('Data berhasil diperbarui!');

        return redirect()->route('dashboard.ruangan-kelas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RuanganKelas $ruanganKelas): RedirectResponse
    {
        $this->ruanganKelasService->destroy($ruanganKelas);
        flash()->success('Data berhasil dihapus!');

        return redirect()->route('dashboard.ruangan-kelas.index');
    }

    /**
     * Remove the specified resources from storage in bulk.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->input('ids');
        if (is_array($ids) && count($ids) > 0) {
            $this->ruanganKelasService->bulkDestroy($ids);
            flash()->success('Berhasil menghapus data terpilih!');
        } else {
            flash()->error('Pilih data terlebih dahulu!');
        }

        return redirect()->route('dashboard.ruangan-kelas.index');
    }
}
