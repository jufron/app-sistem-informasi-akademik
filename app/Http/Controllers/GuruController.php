<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\MataPelajaran;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\DataTables\GuruDataTable;
use App\Services\Interfaces\GuruServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;

class GuruController extends Controller

{
    protected GuruServiceInterface $guruService;

    public function __construct(GuruServiceInterface $guruService)
    {
        $this->guruService = $guruService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GuruDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jenisKelamin = JenisKelamin::all();
        $agama = Agama::all();
        $mataPelajaran = MataPelajaran::all();
        $hasKepalaSekolah = Guru::where('tipe', 'Kepala Sekolah')->exists();
        
        return view('dashboard.admin.guru.tambah', compact('jenisKelamin', 'agama', 'mataPelajaran', 'hasKepalaSekolah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuruRequest $request): RedirectResponse
    {
        $this->guruService->store(
            $request->validated(),
            $request->file('foto')
        );

        flash()->success('Data Guru berhasil ditambahkan!');
        return redirect()->route('dashboard.guru.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru): JsonResponse
    {
        $guru->load(['user', 'jenisKelamin', 'agama', 'mataPelajaran']);
        return response()->json($guru);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru): View
    {
        $jenisKelamin = JenisKelamin::all();
        $agama = Agama::all();
        $mataPelajaran = MataPelajaran::all();
        $guru->load(['user', 'mataPelajaran']);
        $hasKepalaSekolah = Guru::where('tipe', 'Kepala Sekolah')->where('id', '!=', $guru->id)->exists();
        
        return view('dashboard.admin.guru.ubah', compact('guru', 'jenisKelamin', 'agama', 'mataPelajaran', 'hasKepalaSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $this->guruService->update(
            $guru,
            $request->validated(),
            $request->file('foto')
        );

        flash()->success('Data Guru berhasil diperbarui!');
        return redirect()->route('dashboard.guru.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru): RedirectResponse
    {
        $this->guruService->destroy($guru);

        flash()->success('Data Guru berhasil dihapus!');
        return redirect()->route('dashboard.guru.index');
    }

    /**
     * Remove the specified resources from storage in bulk.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = (array) $request->input('ids', []);
        
        if ($this->guruService->bulkDestroy($ids)) {
            flash()->success('Berhasil Menghapus Data Terpilih');
        } else {
            flash()->error('Pilih data terlebih dahulu');
        }

        return redirect()->route('dashboard.guru.index');
    }

    /**
     * Import guru data from a CSV file.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'csv_file.required' => 'File CSV wajib diunggah!',
            'csv_file.file' => 'Input harus berupa file valid!',
            'csv_file.mimes' => 'Format file harus berupa CSV atau TXT!',
            'csv_file.max' => 'Ukuran file maksimal adalah 2MB!',
        ]);

        $file = $request->file('csv_file');
        
        $result = $this->guruService->importFromCsv($file->getRealPath());

        if ($result['imported'] > 0) {
            $msg = "Berhasil mengimpor {$result['imported']} data guru.";
            if ($result['skipped'] > 0) {
                $msg .= " ({$result['skipped']} baris dilewati karena tidak valid)";
            }
            flash()->success($msg);
        } else {
            flash()->error("Tidak ada data guru yang berhasil diimpor. ({$result['skipped']} baris dilewati karena tidak valid)");
        }

        return redirect()->route('dashboard.guru.index');
    }


    /**
     * Download the CSV template for importing guru data.
     *
     * @return StreamedResponse
     */
    public function template(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-guru.csv"',
        ];

        return response()->stream(function () {
            $writer = Writer::createFromPath('php://output', 'w');
            
            $writer->insertOne([
                'Email', 'NIP', 'Nama Lengkap', 'Nama Panggilan', 'Jenis Kelamin', 
                'Agama', 'Tempat Lahir', 'Tanggal Lahir', 'Telepon', 'Alamat', 
                'Tipe Jabatan', 'Status', 'Mata Pelajaran'
            ]);

            // Realistic mock data matching the Antonius Budi structure
            $writer->insertOne([
                'antonius@mail.com',
                '198503122010011002',
                'Antonius Budi, S.Pd',
                'Anton',
                'Laki-laki',
                'Katolik',
                'Weetabula',
                '1985-03-12',
                '081234567890',
                'Jl. Melati No. 12, Weetabula',
                'Wali Kelas',
                'Aktif',
                'Matematika, Ilmu Pengetahuan Alam dan Sosial (IPAS)'
            ]);
        }, 200, $headers);
    }
}

