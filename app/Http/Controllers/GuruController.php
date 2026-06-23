<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\DataTables\GuruDataTable;
use App\Services\Interfaces\GuruServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class GuruController
 * 
 * Thin controller coordinating requests, validation, flash messaging, and routing for teachers.
 */
class GuruController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * Injects only the teacher service interface using PHP 8.0 constructor property promotion.
     * 
     * @param GuruServiceInterface $guruService
     */
    public function __construct(
        protected GuruServiceInterface $guruService
    ) {}

    /**
     * Display a listing of the resource.
     * 
     * @param GuruDataTable $dataTable
     * @return mixed
     */
    public function index(GuruDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return View
     */
    public function create(): View
    {
        $formData = $this->guruService->getFormDataForCreate();
        return view('dashboard.admin.guru.tambah', $formData);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param StoreGuruRequest $request
     * @return RedirectResponse
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
     * 
     * @param Guru $guru
     * @return JsonResponse
     */
    public function show(Guru $guru): JsonResponse
    {
        $guruDetails = $this->guruService->getGuruDetails($guru);
        return response()->json($guruDetails);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param Guru $guru
     * @return View
     */
    public function edit(Guru $guru): View
    {
        $formData = $this->guruService->getFormDataForEdit($guru);
        return view('dashboard.admin.guru.ubah', $formData);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param UpdateGuruRequest $request
     * @param Guru $guru
     * @return RedirectResponse
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
     * 
     * @param Guru $guru
     * @return RedirectResponse
     */
    public function destroy(Guru $guru): RedirectResponse
    {
        $this->guruService->destroy($guru);

        flash()->success('Data Guru berhasil dihapus!');
        return redirect()->route('dashboard.guru.index');
    }

    /**
     * Remove the specified resources from storage in bulk.
     * 
     * @param Request $request
     * @return RedirectResponse
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
            $this->guruService->downloadCsvTemplate();
        }, 200, $headers);
    }
}
