<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppSettingRequest;
use App\Repositories\Interfaces\AppSettingRepositoryInterface;
use App\Services\Interfaces\AppSettingServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class AppSettingController
 * 
 * Manages view rendering and update orchestration for application-wide system configurations.
 */
class AppSettingController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * Injects the settings repository and service layers using constructor property promotion.
     * 
     * @param AppSettingRepositoryInterface $appSettingRepo
     * @param AppSettingServiceInterface $appSettingService
     */
    public function __construct(
        protected AppSettingRepositoryInterface $appSettingRepo,
        protected AppSettingServiceInterface $appSettingService
    ) {}

    /**
     * Display the application settings page.
     * 
     * @return View
     */
    public function index(): View
    {
        $settings = $this->appSettingRepo->pluckKeyValue();
        return view('dashboard.admin.app-setting.index', compact('settings'));
    }

    /**
     * Show the edit form for application settings.
     * 
     * @return View
     */
    public function edit(): View
    {
        $settings = $this->appSettingRepo->pluckKeyValue();
        return view('dashboard.admin.app-setting.edit', compact('settings'));
    }

    /**
     * Update the application settings.
     */
    public function update(UpdateAppSettingRequest $request): RedirectResponse
    {
        $fileFields = [
            'logo_sekolah',
            'hero_foto',
            'foto_kepala_sekolah',
            'struktur_organisasi',
            'foto_sertifikat_akreditasi',
        ];

        $files = [];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $files[$field] = $request->file($field);
            }
        }

        $this->appSettingService->updateSettings(data: $request->validated(), files: $files);

        flash()->success('Pengaturan aplikasi berhasil diperbarui!');
        return redirect()->route('dashboard.app-setting.index');
    }
}
