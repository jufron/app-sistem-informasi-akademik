<x-dashboard.layoutDashboard.app title="Tambah Jadwal Pelajaran">
    <x-slot:myStyle>
        <style>
            .color-option-label {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                border: 3px solid #ffffff;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                transition: all 0.2s ease-in-out;
            }
            .color-option-label:hover {
                transform: scale(1.15);
                box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            }
            .color-option-label.active {
                border-color: #2c3e50 !important;
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            }
            .color-option-label i {
                font-size: 1rem;
                text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fa fa-calendar-plus me-2"></i> Tambah Jadwal Pelajaran</h4>
        </div>

        <form action="{{ route('dashboard.jadwal-pelajaran.store') }}" method="post">
            @csrf
            <div class="card-body">
                
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-book-open me-2"></i> Detail Roster Kelas</h5>
                
                <div class="row">
                    <!-- Dropdown Mata Pelajaran -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group @error('mata_pelajaran_id') has-error @enderror">
                            <label class="form-label">Mata Pelajaran</label>
                            <select class="form-select @error('mata_pelajaran_id') is-invalid @enderror" name="mata_pelajaran_id" required>
                                <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                @foreach($mataPelajarans as $mapel)
                                    <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_pelajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Guru -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group @error('guru_id') has-error @enderror">
                            <label class="form-label">Guru Pengampu</label>
                            <select class="form-select @error('guru_id') is-invalid @enderror" name="guru_id" required>
                                <option value="" disabled selected>-- Pilih Guru Pengampu --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_lengkap }} (NIP. {{ $guru->nip ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Dropdown Kelas -->
                    <div class="col-md-3 mb-3">
                        <div class="form-group @error('kelas_id') has-error @enderror">
                            <label class="form-label">Kelas</label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Rombel -->
                    <div class="col-md-3 mb-3">
                        <div class="form-group @error('rombel_id') has-error @enderror">
                            <label class="form-label">Rombel</label>
                            <select class="form-select @error('rombel_id') is-invalid @enderror" name="rombel_id" required>
                                <option value="" disabled selected>-- Pilih Rombel --</option>
                                @foreach($rombelList as $rombel)
                                    <option value="{{ $rombel->id }}" {{ old('rombel_id') == $rombel->id ? 'selected' : '' }}>
                                        {{ $rombel->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rombel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Semester -->
                    <div class="col-md-3 mb-3">
                        <div class="form-group @error('semester_id') has-error @enderror">
                            <label class="form-label">Semester</label>
                            <select class="form-select @error('semester_id') is-invalid @enderror" name="semester_id" required>
                                <option value="" disabled selected>-- Pilih Semester --</option>
                                @foreach($semesterList as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Ganjil/Genap -->
                    <div class="col-md-3 mb-3">
                        <div class="form-group @error('ganjil_genap') has-error @enderror">
                            <label class="form-label">Periode</label>
                            <select class="form-select @error('ganjil_genap') is-invalid @enderror" name="ganjil_genap" required>
                                <option value="" disabled selected>-- Pilih Periode --</option>
                                <option value="Ganjil" {{ old('ganjil_genap') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('ganjil_genap') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('ganjil_genap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-3 text-muted">

                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-clock me-2"></i> Waktu dan Tempat</h5>

                <div class="row">
                    <!-- Hari -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('hari') has-error @enderror">
                            <label class="form-label">Hari</label>
                            <select class="form-select @error('hari') is-invalid @enderror" name="hari" required>
                                <option value="" disabled selected>-- Pilih Hari --</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                    <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jam Mulai -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('jam_mulai') has-error @enderror">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai') }}" required>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jam Selesai -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('jam_selesai') has-error @enderror">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai') }}" required>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Ruangan -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group @error('ruangan') has-error @enderror">
                            <label class="form-label">Ruangan / Kelas</label>
                            <input type="text" name="ruangan" class="form-control @error('ruangan') is-invalid @enderror" value="{{ old('ruangan') }}" placeholder="Contoh: Ruang Kelas X-A, Laboratorium Komputer" max="100">
                            @error('ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-3 text-muted">

                <!-- Premium Interactive Color Picker Section -->
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-palette me-2"></i> Warna Label Kalender</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="form-label d-block mb-3">Pilih Warna Representatif</label>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                
                                <!-- Preset 1: Cobalt Blue -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label active" style="background-color: #1572e8;" data-color="#1572e8" title="Cobalt Blue">
                                        <input type="radio" name="preset_warna" value="#1572e8" class="d-none" checked>
                                        <i class="fa fa-check text-white fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 2: Royal Purple -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #6610f2;" data-color="#6610f2" title="Royal Purple">
                                        <input type="radio" name="preset_warna" value="#6610f2" class="d-none">
                                        <i class="fa fa-check text-white d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 3: Emerald Green -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #198754;" data-color="#198754" title="Emerald Green">
                                        <input type="radio" name="preset_warna" value="#198754" class="d-none">
                                        <i class="fa fa-check text-white d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 4: Sunset Orange -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #fd7e14;" data-color="#fd7e14" title="Sunset Orange">
                                        <input type="radio" name="preset_warna" value="#fd7e14" class="d-none">
                                        <i class="fa fa-check text-white d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 5: Crimson Red -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #dc3545;" data-color="#dc3545" title="Crimson Red">
                                        <input type="radio" name="preset_warna" value="#dc3545" class="d-none">
                                        <i class="fa fa-check text-white d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 6: Sunny Yellow -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #ffc107;" data-color="#ffc107" title="Sunny Yellow">
                                        <input type="radio" name="preset_warna" value="#ffc107" class="d-none">
                                        <i class="fa fa-check text-dark d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 7: Teal -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #0dcaf0;" data-color="#0dcaf0" title="Teal">
                                        <input type="radio" name="preset_warna" value="#0dcaf0" class="d-none">
                                        <i class="fa fa-check text-white d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Preset 8: Muted Gray -->
                                <div class="color-option-wrapper">
                                    <label class="color-option-label" style="background-color: #6c757d;" data-color="#6c757d" title="Muted Gray">
                                        <input type="radio" name="preset_warna" value="#6c757d" class="d-none">
                                        <i class="fa fa-check text-white d-none fs-6"></i>
                                    </label>
                                </div>

                                <!-- Custom Color Picker Control -->
                                <div class="d-flex align-items-center ms-md-4 p-2 bg-light border rounded-3 shadow-sm" style="cursor: pointer;" id="custom-color-container">
                                    <div class="form-check m-0 d-flex align-items-center">
                                        <input type="radio" name="preset_warna" value="custom" id="preset-custom" class="form-check-input cursor-pointer me-2">
                                        <label for="preset-custom" class="form-check-label cursor-pointer text-dark font-weight-bold mb-0 me-2" style="font-size: 0.9rem;">Warna Kustom:</label>
                                    </div>
                                    <input type="color" id="custom-color-picker" class="form-control form-control-color border-0 p-0 shadow-sm" style="width: 38px; height: 38px; border-radius: 6px; cursor: pointer;" value="#1572e8">
                                </div>

                            </div>
                            
                            <!-- Hidden input representing the final selected color -->
                            <input type="hidden" name="warna" id="final-color-input" value="{{ old('warna', '#1572e8') }}">
                            @error('warna')
                                <div class="alert alert-danger p-2 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="card-action bg-light py-3 border-top d-flex justify-content-start">
                <button type="submit" class="btn btn-success btn-round"><i class="fa fa-save me-1"></i> Simpan Jadwal</button>
                <a href="{{ route('dashboard.jadwal-pelajaran.index') }}" class="btn btn-danger btn-round ms-2"><i class="fa fa-times me-1"></i> Batal</a>
            </div>
        </form>
    </div>

    <x-slot:myScript>
        <script>
            jQuery(function($) {
                // Handle preset color selections
                $('.color-option-label').on('click', function() {
                    // Remove active state from all preset wrapper labels
                    $('.color-option-label').removeClass('active');
                    $('.color-option-label i').addClass('d-none');
                    $('#custom-color-container').removeClass('border-dark');
                    $('#preset-custom').prop('checked', false);

                    // Set active state on clicked label
                    $(this).addClass('active');
                    $(this).find('i').removeClass('d-none');
                    
                    // Update final color value
                    var color = $(this).data('color');
                    $('#final-color-input').val(color);
                });

                // Handle click on Custom Color container or picker
                $('#custom-color-picker').on('input change', function() {
                    // Check the custom radio button
                    $('#preset-custom').prop('checked', true);
                    $('.color-option-label').removeClass('active');
                    $('.color-option-label i').addClass('d-none');
                    $('#custom-color-container').addClass('border-dark');

                    // Sync final color input value
                    var color = $(this).val();
                    $('#final-color-input').val(color);
                });

                $('#preset-custom, #custom-color-container').on('click', function(e) {
                    if (e.target !== $('#custom-color-picker')[0]) {
                        $('#preset-custom').prop('checked', true);
                        $('.color-option-label').removeClass('active');
                        $('.color-option-label i').addClass('d-none');
                        $('#custom-color-container').addClass('border-dark');

                        var color = $('#custom-color-picker').val();
                        $('#final-color-input').val(color);
                    }
                });

                // Restore previous selection on validation failure
                var oldColor = $('#final-color-input').val();
                if (oldColor) {
                    var presetMatched = false;
                    $('.color-option-label').each(function() {
                        if ($(this).data('color') === oldColor) {
                            $('.color-option-label').removeClass('active');
                            $('.color-option-label i').addClass('d-none');
                            $(this).addClass('active');
                            $(this).find('i').removeClass('d-none');
                            presetMatched = true;
                        }
                    });

                    if (!presetMatched) {
                        $('.color-option-label').removeClass('active');
                        $('.color-option-label i').addClass('d-none');
                        $('#preset-custom').prop('checked', true);
                        $('#custom-color-container').addClass('border-dark');
                        $('#custom-color-picker').val(oldColor);
                    }
                }
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
