<x-dashboard.layoutDashboard.app title="Tambah Ruangan Kelas">
    <x-slot:myStyle>
        <!-- Select2 CSS and Theme -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        
        <style>
            .dynamic-row {
                background: #fdfdfd;
                border: 1px solid #ebedf2;
                border-radius: 8px;
                transition: all 0.2s ease-in-out;
            }
            .dynamic-row:hover {
                box-shadow: 0 4px 12px rgba(0,0,0,0.06);
                background: #ffffff;
            }
            .select2-container--bootstrap-5 .select2-selection {
                border-color: #ebedf2 !important;
            }
            .select2-container--bootstrap-5 .select2-selection--single {
                height: calc(2.25rem + 2px) !important;
                line-height: 1.5 !important;
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fa fa-school me-2"></i> Tambah Ruangan Kelas</h4>
        </div>

        <form action="{{ route('dashboard.ruangan-kelas.store') }}" method="post">
            @csrf
            <div class="card-body">
                
                <!-- Section 1: Classroom Information -->
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-info-circle me-2"></i> Detail Informasi Ruangan</h5>
                <div class="row">
                    <!-- Dropdown Kelas -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('kelas_id') has-error @enderror">
                            <label class="form-label">Kelas</label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Rombel -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('rombel_id') has-error @enderror">
                            <label class="form-label">Rombongan Belajar</label>
                            <select class="form-select @error('rombel_id') is-invalid @enderror" name="rombel_id" required>
                                <option value="" disabled selected>-- Pilih Rombongan --</option>
                                @foreach($rombel as $r)
                                    <option value="{{ $r->id }}" {{ old('rombel_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rombel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Semester -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('semester_id') has-error @enderror">
                            <label class="form-label">Semester</label>
                            <select class="form-select @error('semester_id') is-invalid @enderror" name="semester_id" required>
                                <option value="" disabled selected>-- Pilih Semester --</option>
                                @foreach($semester as $s)
                                    <option value="{{ $s->id }}" {{ old('semester_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Dropdown Guru (Wali Kelas) -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('guru_id') has-error @enderror">
                            <label class="form-label">Wali Kelas</label>
                            <select class="form-select @error('guru_id') is-invalid @enderror" name="guru_id" required>
                                <option value="" disabled selected>-- Pilih Wali Kelas --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_lengkap }} (NIP. {{ $g->nip ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tahun Angkatan -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('tahun_angkatan') has-error @enderror">
                            <label class="form-label">Tahun Angkatan</label>
                            <input type="text" name="tahun_angkatan" class="form-control @error('tahun_angkatan') is-invalid @enderror" value="{{ old('tahun_angkatan') }}" placeholder="Contoh: 2023" required max="4">
                            @error('tahun_angkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tahun Ajaran -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('tahun_ajaran') has-error @enderror">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" value="{{ old('tahun_ajaran') }}" placeholder="Contoh: 2023/2024" required>
                            @error('tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Status Aktif -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group @error('aktif') has-error @enderror">
                            <label class="form-label d-block">Status Ruangan</label>
                            <div class="d-flex align-items-center mt-2">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="aktif" id="status-aktif" value="1" {{ old('aktif', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold text-success" for="status-aktif">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="aktif" id="status-nonaktif" value="0" {{ old('aktif') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold text-danger" for="status-nonaktif">Tidak Aktif</label>
                                </div>
                            </div>
                            @error('aktif')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <!-- Section 2: Dynamic Searchable Student Inputs with full pivot details -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-primary font-weight-bold m-0"><i class="fa fa-users me-2"></i> Anggota Kelas (Siswa)</h5>
                    <button type="button" id="btn-add-siswa" class="btn btn-outline-primary btn-sm btn-round">
                        <i class="fa fa-plus-circle me-1"></i> Tambah Baris Siswa
                    </button>
                </div>

                <!-- Table Header for Large Screens -->
                <div class="row px-3 mb-2 d-none d-lg-flex text-secondary font-weight-bold" style="font-size: 0.9rem;">
                    <div class="col-lg-3">Nama Siswa <span class="text-danger">*</span></div>
                    <div class="col-lg-2">Tanggal Masuk <span class="text-danger">*</span></div>
                    <div class="col-lg-2">Tanggal Keluar</div>
                    <div class="col-lg-2">Status <span class="text-danger">*</span></div>
                    <div class="col-lg-2">Keterangan</div>
                    <div class="col-lg-1 text-center">Aksi</div>
                </div>

                <div id="siswa-wrapper">
                    <!-- Renders 5 initial dynamic searchable rows with all required pivot fields -->
                    @for ($i = 0; $i < 5; $i++)
                        <div class="row dynamic-row align-items-end py-2 px-3 mb-2 shadow-xs">
                            <!-- Student Select -->
                            <div class="col-lg-3 col-md-12 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Siswa</label>
                                <select class="form-select student-select" name="siswa_ids[]">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $s)
                                        <option value="{{ $s->id }}" {{ old('siswa_ids.'.$i) == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_lengkap }} (NISN. {{ $s->nisn ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Tanggal Masuk -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Tgl Masuk</label>
                                <input type="date" name="tanggal_masuks[]" class="form-control" value="{{ old('tanggal_masuks.'.$i, date('Y-m-d')) }}" title="Tanggal Masuk" required>
                            </div>

                            <!-- Tanggal Keluar -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Tgl Keluar (Opsional)</label>
                                <input type="date" name="tanggal_keluars[]" class="form-control" value="{{ old('tanggal_keluars.'.$i) }}" title="Tanggal Keluar (Opsional)">
                            </div>

                            <!-- Status -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Status</label>
                                <select name="statuses[]" class="form-select" title="Status">
                                    @foreach(['Aktif', 'Naik Kelas', 'Tinggal Kelas', 'Mutasi Keluar', 'Mutasi Masuk', 'Lulus', 'Keluar'] as $opt)
                                        <option value="{{ $opt }}" {{ old('statuses.'.$i, 'Aktif') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Keterangan -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Keterangan</label>
                                <input type="text" name="keterangans[]" class="form-control" value="{{ old('keterangans.'.$i) }}" placeholder="Keterangan..." title="Keterangan">
                            </div>

                            <!-- Hapus button -->
                            <div class="col-lg-1 col-md-12 mb-2 text-end text-lg-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-round btn-remove-row" {{ $i < 1 ? 'disabled' : '' }}>
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>

            </div>
            
            <div class="card-action bg-light py-3 border-top d-flex justify-content-start">
                <button type="submit" class="btn btn-success btn-round"><i class="fa fa-save me-1"></i> Simpan</button>
                <a href="{{ route('dashboard.ruangan-kelas.index') }}" class="btn btn-danger btn-round ms-2"><i class="fa fa-times me-1"></i> Batal</a>
            </div>
        </form>
    </div>

    <x-slot:myScript>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script>
            jQuery(function($) {
                // Initialize Select2 on existing student selects
                function initSelect2(element) {
                    element.select2({
                        theme: 'bootstrap-5',
                        placeholder: '-- Pilih Siswa --',
                        allowClear: true,
                        width: '100%'
                    });
                }

                // Initial instantiation
                $('.student-select').each(function() {
                    initSelect2($(this));
                });

                // Add dynamic student select input row
                $('#btn-add-siswa').on('click', function() {
                    // Option template copied from first select
                    var optionsHtml = $('.student-select').first().html();
                    var currentDate = new Date().toISOString().split('T')[0];

                    var newRow = `
                        <div class="row dynamic-row align-items-end py-2 px-3 mb-2 shadow-xs" style="display:none;">
                            <!-- Student Select -->
                            <div class="col-lg-3 col-md-12 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Siswa</label>
                                <select class="form-select student-select" name="siswa_ids[]">
                                    ${optionsHtml}
                                </select>
                            </div>
                            
                            <!-- Tanggal Masuk -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Tgl Masuk</label>
                                <input type="date" name="tanggal_masuks[]" class="form-control" value="${currentDate}" title="Tanggal Masuk" required>
                            </div>

                            <!-- Tanggal Keluar -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Tgl Keluar (Opsional)</label>
                                <input type="date" name="tanggal_keluars[]" class="form-control" title="Tanggal Keluar (Opsional)">
                            </div>

                            <!-- Status -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Status</label>
                                <select name="statuses[]" class="form-select" title="Status">
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Naik Kelas">Naik Kelas</option>
                                    <option value="Tinggal Kelas">Tinggal Kelas</option>
                                    <option value="Mutasi Keluar">Mutasi Keluar</option>
                                    <option value="Mutasi Masuk">Mutasi Masuk</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Keluar">Keluar</option>
                                </select>
                            </div>

                            <!-- Keterangan -->
                            <div class="col-lg-2 col-md-6 mb-2">
                                <label class="form-label font-weight-bold text-dark d-lg-none">Keterangan</label>
                                <input type="text" name="keterangans[]" class="form-control" placeholder="Keterangan..." title="Keterangan">
                            </div>

                            <!-- Hapus button -->
                            <div class="col-lg-1 col-md-12 mb-2 text-end text-lg-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-round btn-remove-row">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    // Append and animate in
                    var $newRow = $(newRow);
                    $('#siswa-wrapper').append($newRow);
                    $newRow.slideDown(200);

                    // Initialize Select2 on the new dropdown
                    initSelect2($newRow.find('.student-select'));

                    updateRowNumbers();
                });

                // Remove dynamic row
                $(document).on('click', '.btn-remove-row', function() {
                    var $row = $(this).closest('.dynamic-row');
                    $row.slideUp(200, function() {
                        // Destroy select2 instance before removing to prevent leaks
                        $row.find('.student-select').select2('destroy');
                        $row.remove();
                        updateRowNumbers();
                    });
                });

                // Recalculate row constraints (e.g. prevent deleting first item)
                function updateRowNumbers() {
                    $('.dynamic-row').each(function(index) {
                        var btnRemove = $(this).find('.btn-remove-row');
                        if (index === 0) {
                            btnRemove.prop('disabled', true);
                        } else {
                            btnRemove.prop('disabled', false);
                        }
                    });
                }
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
