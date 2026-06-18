<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAppSettingRequest;
use App\Models\AppSetting;
use App\Services\Interfaces\AppSettingServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppSettingController extends Controller
{
    protected AppSettingServiceInterface $appSettingService;

    /**
     * Create a new controller instance.
     */
    public function __construct(AppSettingServiceInterface $appSettingService)
    {
        $this->appSettingService = $appSettingService;
    }

    /**
     * Display the application settings page.
     */
    public function index(): View
    {
        $settings = AppSetting::pluck('value', 'key')->all();
        return view('dashboard.admin.app-setting.index', compact('settings'));
    }

    /**
     * Show the edit form for application settings.
     */
    public function edit(): View
    {
        $settings = AppSetting::pluck('value', 'key')->all();
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

        $this->appSettingService->updateSettings($request->validated(), $files);

        flash()->success('Pengaturan aplikasi berhasil diperbarui!');
        return redirect()->route('dashboard.app-setting.index');
    }
}
