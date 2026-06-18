<x-dashboard.layoutDashboard.app title="Edit Pengaturan Aplikasi">
    <x-slot:myStyle>
        <style>
            .setting-preview-img-container {
                width: 100%;
                max-width: 250px;
                height: 150px;
                border-radius: 8px;
                border: 2px dashed #ced4da;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 10px;
                background-color: #f8f9fa;
                transition: border-color 0.2s;
            }
            .setting-preview-img-container:hover {
                border-color: #1572e8;
            }
            .setting-preview-img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }
            .logo-preview-img-container {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 2px dashed #ced4da;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 10px;
                background-color: #f8f9fa;
                transition: border-color 0.2s;
            }
            .logo-preview-img-container:hover {
                border-color: #1572e8;
            }
            .logo-preview-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
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
        </style>
    </x-slot:myStyle>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title font-weight-bold"><i class="fas fa-edit me-2 text-primary"></i> Edit Pengaturan Aplikasi</h4>
                        <p class="card-category text-muted m-0">Ubah identitas, kontak, sambutan, media, dan profil sosial media sekolah.</p>
                    </div>
                    <a href="{{ route('dashboard.app-setting.index') }}" class="btn btn-secondary btn-round">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('dashboard.app-setting.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-dashboard.input
                                            label="Nama Sekolah"
                                            name="nama_sekolah"
                                            value="{{ old('nama_sekolah', $settings['nama_sekolah'] ?? '') }}"
                                            placeholder="Masukkan nama sekolah"
                                        />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="akreditasi">Akreditasi</label>
                                            <select name="akreditasi" id="akreditasi" class="form-select @error('akreditasi') is-invalid @enderror">
                                                <option value="" disabled>-- Pilih Akreditasi --</option>
                                                <option value="A" {{ old('akreditasi', $settings['akreditasi'] ?? '') === 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                                <option value="B" {{ old('akreditasi', $settings['akreditasi'] ?? '') === 'B' ? 'selected' : '' }}>B (Baik)</option>
                                                <option value="C" {{ old('akreditasi', $settings['akreditasi'] ?? '') === 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                                <option value="Belum Terakreditasi" {{ old('akreditasi', $settings['akreditasi'] ?? '') === 'Belum Terakreditasi' ? 'selected' : '' }}>Belum Terakreditasi</option>
                                            </select>
                                            @error('akreditasi')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <x-dashboard.input
                                            label="Telepon Kantor"
                                            name="nomor_telepon_kantor"
                                            value="{{ old('nomor_telepon_kantor', $settings['nomor_telepon_kantor'] ?? '') }}"
                                            placeholder="Contoh: 021-123456"
                                        />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-dashboard.input
                                            label="WhatsApp Sekolah"
                                            name="nomor_telepon_whatsapp"
                                            value="{{ old('nomor_telepon_whatsapp', $settings['nomor_telepon_whatsapp'] ?? '') }}"
                                            placeholder="Contoh: 081234567890"
                                        />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-dashboard.input
                                            label="Email Resmi Sekolah"
                                            name="email"
                                            type="email"
                                            value="{{ old('email', $settings['email'] ?? '') }}"
                                            placeholder="Contoh: info@sekolah.sch.id"
                                        />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-dashboard.input-textarea
                                            label="Alamat Sekolah"
                                            name="alamat_sekolah"
                                            rows="3"
                                            value="{!! old('alamat_sekolah', $settings['alamat_sekolah'] ?? '') !!}"
                                            placeholder="Masukkan alamat lengkap sekolah"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: PROFIL & SAMBUTAN -->
                            <div class="tab-pane fade" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-dashboard.input
                                            label="Nama Kepala Sekolah"
                                            name="nama_kepala_sekolah"
                                            value="{{ old('nama_kepala_sekolah', $settings['nama_kepala_sekolah'] ?? '') }}"
                                            placeholder="Masukkan nama kepala sekolah beserta gelar"
                                        />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-dashboard.input-textarea
                                            label="Sambutan Kepala Sekolah"
                                            name="sambutan_kepala_sekolah"
                                            rows="4"
                                            value="{!! old('sambutan_kepala_sekolah', $settings['sambutan_kepala_sekolah'] ?? '') !!}"
                                            placeholder="Tuliskan sambutan resmi dari kepala sekolah..."
                                        />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-dashboard.input-textarea
                                            label="Sejarah Sekolah"
                                            name="sejarah"
                                            rows="5"
                                            value="{!! old('sejarah', $settings['sejarah'] ?? '') !!}"
                                            placeholder="Tuliskan sejarah berdirinya sekolah..."
                                        />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-dashboard.input-textarea
                                            label="Visi Sekolah"
                                            name="visi"
                                            rows="4"
                                            value="{!! old('visi', $settings['visi'] ?? '') !!}"
                                            placeholder="Tuliskan visi sekolah..."
                                        />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-dashboard.input-textarea
                                            label="Misi Sekolah"
                                            name="misi"
                                            rows="4"
                                            value="{!! old('misi', $settings['misi'] ?? '') !!}"
                                            placeholder="Tuliskan misi sekolah (pisahkan per poin)..."
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: MEDIA & FOTO -->
                            <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                                <div class="row">
                                    
                                    <!-- LOGO SEKOLAH -->
                                    <div class="col-md-4 mb-4 text-center border-end">
                                        <div class="form-group p-0">
                                            <label class="form-label d-block font-weight-bold">Logo Sekolah</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="logo-preview-img-container">
                                                    @php
                                                        $logoVal = $settings['logo_sekolah'] ?? '';
                                                        $logoUrl = $logoVal ? (str_starts_with($logoVal, 'assets/') ? asset($logoVal) : asset('storage/' . $logoVal)) : 'https://via.placeholder.com/150?text=Logo';
                                                    @endphp
                                                    <img id="logo_sekolah-preview" src="{{ $logoUrl }}" alt="Logo Sekolah" class="logo-preview-img">
                                                </div>
                                            </div>
                                            <input type="file" name="logo_sekolah" id="logo_sekolah-input" class="form-control @error('logo_sekolah') is-invalid @enderror" accept="image/*">
                                            @error('logo_sekolah')
                                                <div class="invalid-feedback text-start">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP, ICO (Maks. 2MB)</small>
                                        </div>
                                    </div>

                                    <!-- FOTO KEPALA SEKOLAH -->
                                    <div class="col-md-4 mb-4 text-center border-end">
                                        <div class="form-group p-0">
                                            <label class="form-label d-block font-weight-bold">Foto Kepala Sekolah</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="logo-preview-img-container">
                                                    @php
                                                        $fotoKepsekVal = $settings['foto_kepala_sekolah'] ?? '';
                                                        $fotoKepsekUrl = $fotoKepsekVal ? (str_starts_with($fotoKepsekVal, 'assets/') ? asset($fotoKepsekVal) : asset('storage/' . $fotoKepsekVal)) : 'https://via.placeholder.com/150?text=Foto';
                                                    @endphp
                                                    <img id="foto_kepala_sekolah-preview" src="{{ $fotoKepsekUrl }}" alt="Foto Kepala Sekolah" class="logo-preview-img">
                                                </div>
                                            </div>
                                            <input type="file" name="foto_kepala_sekolah" id="foto_kepala_sekolah-input" class="form-control @error('foto_kepala_sekolah') is-invalid @enderror" accept="image/*">
                                            @error('foto_kepala_sekolah')
                                                <div class="invalid-feedback text-start">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                                        </div>
                                    </div>

                                    <!-- HERO FOTO -->
                                    <div class="col-md-4 mb-4 text-center">
                                        <div class="form-group p-0">
                                            <label class="form-label d-block font-weight-bold">Hero Foto (Banner Depan)</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="setting-preview-img-container">
                                                    @php
                                                        $heroVal = $settings['hero_foto'] ?? '';
                                                        $heroUrl = $heroVal ? (str_starts_with($heroVal, 'assets/') ? asset($heroVal) : asset('storage/' . $heroVal)) : 'https://via.placeholder.com/300x150?text=Hero+Banner';
                                                    @endphp
                                                    <img id="hero_foto-preview" src="{{ $heroUrl }}" alt="Hero Foto" class="setting-preview-img">
                                                </div>
                                            </div>
                                            <input type="file" name="hero_foto" id="hero_foto-input" class="form-control @error('hero_foto') is-invalid @enderror" accept="image/*">
                                            @error('hero_foto')
                                                <div class="invalid-feedback text-start">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks. 4MB)</small>
                                        </div>
                                    </div>

                                </div>

                                <hr class="my-4 text-muted">

                                <div class="row">
                                    
                                    <!-- STRUKTUR ORGANISASI -->
                                    <div class="col-md-6 mb-4 text-center border-end">
                                        <div class="form-group p-0">
                                            <label class="form-label d-block font-weight-bold">Struktur Organisasi</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="setting-preview-img-container" style="max-width: 350px;">
                                                    @php
                                                        $strukturVal = $settings['struktur_organisasi'] ?? '';
                                                        $strukturUrl = $strukturVal ? (str_starts_with($strukturVal, 'assets/') ? asset($strukturVal) : asset('storage/' . $strukturVal)) : 'https://via.placeholder.com/350x150?text=Struktur+Organisasi';
                                                    @endphp
                                                    <img id="struktur_organisasi-preview" src="{{ $strukturUrl }}" alt="Struktur Organisasi" class="setting-preview-img">
                                                </div>
                                            </div>
                                            <input type="file" name="struktur_organisasi" id="struktur_organisasi-input" class="form-control @error('struktur_organisasi') is-invalid @enderror" accept="image/*">
                                            @error('struktur_organisasi')
                                                <div class="invalid-feedback text-start">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks. 4MB)</small>
                                        </div>
                                    </div>

                                    <!-- FOTO SERTIFIKAT AKREDITASI -->
                                    <div class="col-md-6 mb-4 text-center">
                                        <div class="form-group p-0">
                                            <label class="form-label d-block font-weight-bold">Foto Sertifikat Akreditasi</label>
                                            <div class="d-flex justify-content-center">
                                                <div class="setting-preview-img-container" style="max-width: 350px;">
                                                    @php
                                                        $akredVal = $settings['foto_sertifikat_akreditasi'] ?? '';
                                                        $akredUrl = $akredVal ? (str_starts_with($akredVal, 'assets/') ? asset($akredVal) : asset('storage/' . $akredVal)) : 'https://via.placeholder.com/350x150?text=Sertifikat+Akreditasi';
                                                    @endphp
                                                    <img id="foto_sertifikat_akreditasi-preview" src="{{ $akredUrl }}" alt="Sertifikat Akreditasi" class="setting-preview-img">
                                                </div>
                                            </div>
                                            <input type="file" name="foto_sertifikat_akreditasi" id="foto_sertifikat_akreditasi-input" class="form-control @error('foto_sertifikat_akreditasi') is-invalid @enderror" accept="image/*">
                                            @error('foto_sertifikat_akreditasi')
                                                <div class="invalid-feedback text-start">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks. 4MB)</small>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- TAB 4: SOSIAL MEDIA & TAUTAN -->
                            <div class="tab-pane fade" id="sosmed" role="tabpanel" aria-labelledby="sosmed-tab">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-dashboard.input
                                            label="Link Facebook Sekolah"
                                            name="link_facebook"
                                            value="{{ old('link_facebook', $settings['link_facebook'] ?? '') }}"
                                            placeholder="Contoh: https://facebook.com/namapage"
                                        />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-dashboard.input
                                            label="Link Instagram Sekolah"
                                            name="link_instagram"
                                            value="{{ old('link_instagram', $settings['link_instagram'] ?? '') }}"
                                            placeholder="Contoh: https://instagram.com/akunsekolah"
                                        />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-dashboard.input
                                            label="Tautan / Link Email (Untuk aksi klik email)"
                                            name="link_email"
                                            value="{{ old('link_email', $settings['link_email'] ?? '') }}"
                                            placeholder="Contoh: mailto:info@sekolah.sch.id"
                                        />
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card-action bg-light border-top">
                        <button type="submit" class="btn btn-success btn-round px-4 py-2">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard.app-setting.index') }}" class="btn btn-danger btn-round px-4 py-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot:myScript>
        <script>
            // Helper function to setup live image preview
            function setupImagePreview(inputId, previewId) {
                var input = document.getElementById(inputId);
                var preview = document.getElementById(previewId);

                if (input && preview) {
                    input.addEventListener('change', function(event) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            preview.src = reader.result;
                        };
                        if (event.target.files[0]) {
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    });
                }
            }

            // Setup previews for all five upload inputs
            setupImagePreview('logo_sekolah-input', 'logo_sekolah-preview');
            setupImagePreview('foto_kepala_sekolah-input', 'foto_kepala_sekolah-preview');
            setupImagePreview('hero_foto-input', 'hero_foto-preview');
            setupImagePreview('struktur_organisasi-input', 'struktur_organisasi-preview');
            setupImagePreview('foto_sertifikat_akreditasi-input', 'foto_sertifikat_akreditasi-preview');
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
