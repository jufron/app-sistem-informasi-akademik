<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\DataTables\SiswaDataTable;
use App\Services\Interfaces\SiswaServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class SiswaController
 *
 * Coordinates administrative HTTP requests, form validations, data formatting, and file imports
 * for the Student (Siswa) CRUD dashboard resource.
 */
class SiswaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param SiswaServiceInterface $siswaService Inject the service responsible for student business logic
     */
    public function __construct(
        protected SiswaServiceInterface $siswaService
    ) {}

    /**
     * Display a listing of the student resource using Yajra DataTables.
     * 
     * @param SiswaDataTable $dataTable Yajra DataTable builder class
     * @return mixed Rendered datatable view or AJAX response
     */
    public function index(SiswaDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.siswa.index');
    }

    /**
     * Show the form for creating a new student resource.
     * 
     * @return View Form view with Genders and Religions dropdown options
     */
    public function create(): View
    {
        $formData = $this->siswaService->getFormDataForCreate();
        return view('dashboard.admin.siswa.tambah', $formData);
    }

    /**
     * Store a newly created student and associated user account in database storage.
     * 
     * @param StoreSiswaRequest $request Form validation request
     * @return RedirectResponse Redirect to list view with status flash message
     */
    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        $this->siswaService->store(
            $request->validated(),
            $request->file('foto')
        );

        flash()->success('Data Siswa berhasil ditambahkan!');
        return redirect()->route('dashboard.siswa.index');
    }

    /**
     * Display detailed JSON information of the specified student.
     * 
     * @param Siswa $siswa Implicitly bound student model instance
     * @return JsonResponse JSON object containing student and loaded relations
     */
    public function show(Siswa $siswa): JsonResponse
    {
        $siswaDetails = $this->siswaService->getSiswaDetails($siswa);
        return response()->json($siswaDetails);
    }

    /**
     * Show the form for editing the specified student resource.
     * 
     * @param Siswa $siswa Implicitly bound student model instance
     * @return View Edit form view populated with current student record data
     */
    public function edit(Siswa $siswa): View
    {
        $formData = $this->siswaService->getFormDataForEdit($siswa);
        return view('dashboard.admin.siswa.ubah', $formData);
    }

    /**
     * Update the specified student and user account details in database storage.
     * 
     * @param UpdateSiswaRequest $request Validation rules for editing student records
     * @param Siswa $siswa Implicitly bound student model instance
     * @return RedirectResponse Redirect to list view with status flash message
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $this->siswaService->update(
            $siswa,
            $request->validated(),
            $request->file('foto')
        );

        flash()->success('Data Siswa berhasil diperbarui!');
        return redirect()->route('dashboard.siswa.index');
    }

    /**
     * Remove the specified student and associated user account from storage.
     * 
     * @param Siswa $siswa Implicitly bound student model instance
     * @return RedirectResponse Redirect to list view with status flash message
     */
    public function destroy(Siswa $siswa): RedirectResponse
    {
        $this->siswaService->destroy($siswa);

        flash()->success('Data Siswa berhasil dihapus!');
        return redirect()->route('dashboard.siswa.index');
    }

    /**
     * Remove the specified multiple student records in bulk.
     * 
     * @param Request $request Request containing array of student IDs
     * @return RedirectResponse Redirect to list view with success or error message
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = (array) $request->input('ids', []);
        
        if ($this->siswaService->bulkDestroy($ids)) {
            flash()->success('Berhasil Menghapus Data Terpilih');
        } else {
            flash()->error('Pilih data terlebih dahulu');
        }

        return redirect()->route('dashboard.siswa.index');
    }

    /**
     * Import multiple student records from a CSV file.
     *
     * @param Request $request Request containing uploaded CSV file
     * @return RedirectResponse Redirect to list view with import summary message
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
        
        $result = $this->siswaService->importFromCsv(file: $file->getRealPath());

        if ($result['imported'] > 0) {
            $msg = "Berhasil mengimpor {$result['imported']} data siswa.";
            if ($result['skipped'] > 0) {
                $msg .= " ({$result['skipped']} baris dilewati karena tidak valid)";
            }
            flash()->success($msg);
        } else {
            flash()->error("Tidak ada data siswa yang berhasil diimpor. ({$result['skipped']} baris dilewati karena tidak valid)");
        }

        return redirect()->route('dashboard.siswa.index');
    }

    /**
     * Download the standard CSV template for mass student imports.
     *
     * @return StreamedResponse Streamed CSV file download response
     */
    public function template(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-siswa.csv"',
        ];

        return response()->stream(function () {
            $this->siswaService->downloadCsvTemplate();
        }, 200, $headers);
    }
}
