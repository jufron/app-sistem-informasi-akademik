<x-dashboard.layoutDashboard.app title="Pengaturan Aplikasi">
    <x-slot:myStyle>
        <style>
            .setting-view-img-container {
                width: 100%;
                max-width: 250px;
                height: 150px;
                border-radius: 8px;
                border: 1px solid #ebedf2;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 10px;
                background-color: #f8f9fa;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            .setting-view-img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                transition: transform 0.3s;
            }
            .setting-view-img:hover {
                transform: scale(1.05);
            }
            .logo-view-img-container {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 1px solid #ebedf2;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 10px;
                background-color: #f8f9fa;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            .logo-view-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
                transition: transform 0.3s;
            }
            .logo-view-img:hover {
                transform: scale(1.05);
            }
            .nav-pills.nav-secondary .nav-link.active {
                background-color: #1572e8 !important;
                color: #fff !important;
                font-weight: 600;
                box-shadow: 0 4px 10px rgba(21, 114, 232, 0.3);
            }
            .nav-pills .nav-link {
                color: #575962;
                border: 1px solid #ebedf2;
                margin-right: 8px;
                border-radius: 6px;
                transition: all 0.2s;
            }
            .nav-pills .nav-link:hover {
                background-color: #f1f7ff;
                border-color: #1572e8;
            }
            .setting-label {
                font-weight: 600;
                color: #495057;
                width: 30%;
            }
            .setting-value {
                color: #212529;
            }
            .setting-card-detail {
                background-color: #fafafa;
                border: 1px solid #ebedf2;
                border-radius: 8px;
                padding: 15px 20px;
                margin-bottom: 15px;
            }
        </style>
    </x-slot:myStyle>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title font-weight-bold"><i class="fas fa-cog me-2 text-primary"></i> Pengaturan Aplikasi</h4>
                        <p class="card-category text-muted m-0">Tinjau identitas, kontak, sambutan, media, dan profil sosial media sekolah.</p>
                    </div>
                    <a href="{{ route('dashboard.app-setting.edit') }}" class="btn btn-primary btn-round px-4 py-2">
                        <i class="fas fa-edit me-1"></i> Edit Pengaturan
                    </a>
                </div>

                <div class="card-body">
                    
                    <!-- Nav Tabs -->
                    <ul class="nav nav-pills nav-secondary mb-4" id="settingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="umum-tab" data-bs-toggle="pill" data-bs-target="#umum" type="button" role="tab" aria-controls="umum" aria-selected="true">
                                <i class="fas fa-info-circle me-1"></i> Informasi Umum
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profil-tab" data-bs-toggle="pill" data-bs-target="#profil" type="button" role="tab" aria-controls="profil" aria-selected="false">
                                <i class="fas fa-user-tie me-1"></i> Profil & Sambutan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="media-tab" data-bs-toggle="pill" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false">
                                <i class="fas fa-image me-1"></i> Media & Foto
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sosmed-tab" data-bs-toggle="pill" data-bs-target="#sosmed" type="button" role="tab" aria-controls="sosmed" aria-selected="false">
                                <i class="fas fa-share-alt me-1"></i> Sosial Media & Tautan
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-2" id="settingTabContent">
                        
                        <!-- TAB 1: INFORMASI UMUM -->
                        <div class="tab-pane fade show active" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mt-2">
                                    <tbody>
                                        <tr>
                                            <td class="setting-label">Nama Sekolah</td>
                                            <td style="width: 5%">:</td>
                                            <td class="setting-value font-weight-bold text-primary">{{ $settings['nama_sekolah'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">Akreditasi</td>
                                            <td>:</td>
                                            <td class="setting-value">
                                                <span class="badge bg-success text-white px-3 py-2 font-weight-bold" style="font-size: 0.9rem;">
                                                    {{ $settings['akreditasi'] ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">Telepon Kantor</td>
                                            <td>:</td>
                                            <td class="setting-value">{{ $settings['nomor_telepon_kantor'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">WhatsApp Sekolah</td>
                                            <td>:</td>
                                            <td class="setting-value">
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['nomor_telepon_whatsapp'] ?? '') }}" target="_blank" class="text-success font-weight-bold">
                                                    <i class="fab fa-whatsapp me-1"></i> {{ $settings['nomor_telepon_whatsapp'] ?? '-' }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">Email Resmi</td>
                                            <td>:</td>
                                            <td class="setting-value">
                                                <a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '-' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">Alamat Sekolah</td>
                                            <td>:</td>
                                            <td class="setting-value" style="white-space: pre-line;">{{ $settings['alamat_sekolah'] ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- TAB 2: PROFIL & SAMBUTAN -->
                        <div class="tab-pane fade" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                            <div class="setting-card-detail">
                                <h5 class="font-weight-bold text-primary mb-2"><i class="fas fa-user-tie me-1"></i> Kepala Sekolah</h5>
                                <p class="setting-value mb-1 font-weight-bold">{{ $settings['nama_kepala_sekolah'] ?? '-' }}</p>
                            </div>

                            <div class="setting-card-detail">
                                <h5 class="font-weight-bold text-primary mb-2"><i class="fas fa-comment-dots me-1"></i> Sambutan Kepala Sekolah</h5>
                                <p class="setting-value" style="white-space: pre-line; line-height: 1.6;">{{ $settings['sambutan_kepala_sekolah'] ?? '-' }}</p>
                            </div>

                            <div class="setting-card-detail">
                                <h5 class="font-weight-bold text-primary mb-2"><i class="fas fa-history me-1"></i> Sejarah Sekolah</h5>
                                <p class="setting-value" style="white-space: pre-line; line-height: 1.6;">{{ $settings['sejarah'] ?? '-' }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="setting-card-detail h-100">
                                        <h5 class="font-weight-bold text-primary mb-2"><i class="fas fa-eye me-1"></i> Visi</h5>
                                        <p class="setting-value" style="white-space: pre-line; line-height: 1.6;">{{ $settings['visi'] ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="setting-card-detail h-100">
                                        <h5 class="font-weight-bold text-primary mb-2"><i class="fas fa-bullseye me-1"></i> Misi</h5>
                                        <p class="setting-value" style="white-space: pre-line; line-height: 1.6;">{{ $settings['misi'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: MEDIA & FOTO -->
                        <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                            <div class="row text-center">
                                
                                <!-- LOGO SEKOLAH -->
                                <div class="col-md-4 mb-4 border-end">
                                    <h6 class="font-weight-bold text-dark mb-3">Logo Sekolah</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="logo-view-img-container">
                                            @php
                                                $logoUrl = get_app_setting_url('logo_sekolah');
                                            @endphp
                                            <img src="{{ $logoUrl }}" alt="Logo Sekolah" class="logo-view-img">
                                        </div>
                                    </div>
                                </div>

                                <!-- FOTO KEPALA SEKOLAH -->
                                <div class="col-md-4 mb-4 border-end">
                                    <h6 class="font-weight-bold text-dark mb-3">Foto Kepala Sekolah</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="logo-view-img-container">
                                            @php
                                                $fotoKepsekUrl = get_app_setting_url('foto_kepala_sekolah');
                                            @endphp
                                            <img src="{{ $fotoKepsekUrl }}" alt="Foto Kepala Sekolah" class="logo-view-img">
                                        </div>
                                    </div>
                                </div>

                                <!-- HERO FOTO -->
                                <div class="col-md-4 mb-4">
                                    <h6 class="font-weight-bold text-dark mb-3">Hero Foto (Banner Depan)</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="setting-view-img-container">
                                            @php
                                                $heroUrl = get_app_setting_url('hero_foto');
                                            @endphp
                                            <img src="{{ $heroUrl }}" alt="Hero Foto" class="setting-view-img">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr class="my-4 text-muted">

                            <div class="row text-center">
                                
                                <!-- STRUKTUR ORGANISASI -->
                                <div class="col-md-6 mb-4 border-end">
                                    <h6 class="font-weight-bold text-dark mb-3">Struktur Organisasi</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="setting-view-img-container" style="max-width: 350px; height: 200px;">
                                            @php
                                                $strukturUrl = get_app_setting_url('struktur_organisasi');
                                            @endphp
                                            <img src="{{ $strukturUrl }}" alt="Struktur Organisasi" class="setting-view-img">
                                        </div>
                                    </div>
                                </div>

                                <!-- FOTO SERTIFIKAT AKREDITASI -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="font-weight-bold text-dark mb-3">Foto Sertifikat Akreditasi</h6>
                                    <div class="d-flex justify-content-center">
                                        <div class="setting-view-img-container" style="max-width: 350px; height: 200px;">
                                            @php
                                                $akredUrl = get_app_setting_url('foto_sertifikat_akreditasi');
                                            @endphp
                                            <img src="{{ $akredUrl }}" alt="Sertifikat Akreditasi" class="setting-view-img">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- TAB 4: SOSIAL MEDIA & TAUTAN -->
                        <div class="tab-pane fade" id="sosmed" role="tabpanel" aria-labelledby="sosmed-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mt-2">
                                    <tbody>
                                        <tr>
                                            <td class="setting-label">Facebook Sekolah</td>
                                            <td style="width: 5%">:</td>
                                            <td class="setting-value">
                                                @if(isset($settings['link_facebook']))
                                                    <a href="{{ $settings['link_facebook'] }}" target="_blank" class="text-primary font-weight-bold">
                                                        <i class="fab fa-facebook me-1"></i> {{ $settings['link_facebook'] }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">Instagram Sekolah</td>
                                            <td>:</td>
                                            <td class="setting-value">
                                                @if(isset($settings['link_instagram']))
                                                    <a href="{{ $settings['link_instagram'] }}" target="_blank" class="text-danger font-weight-bold">
                                                        <i class="fab fa-instagram me-1"></i> {{ $settings['link_instagram'] }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">YouTube Sekolah</td>
                                            <td>:</td>
                                            <td class="setting-value">
                                                @if(isset($settings['link_youtube']) && $settings['link_youtube'])
                                                    <a href="{{ $settings['link_youtube'] }}" target="_blank" class="text-danger font-weight-bold" style="color: #ff0000 !important;">
                                                        <i class="fab fa-youtube me-1"></i> {{ $settings['link_youtube'] }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="setting-label">Tautan Klik Email</td>
                                            <td>:</td>
                                            <td class="setting-value">
                                                @if(isset($settings['link_email']))
                                                    <a href="{{ $settings['link_email'] }}" class="font-weight-bold">
                                                        <i class="fas fa-envelope me-1"></i> {{ $settings['link_email'] }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
