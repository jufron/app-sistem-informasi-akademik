<x-dashboard.layoutDashboard.app title="Absensi Roster Siswa">
    <x-slot:myStyle>
        <style>
            .header-banner {
                background: linear-gradient(135deg, #ff9800 0%, #fd7e14 100%);
                border-radius: 16px;
                position: relative;
                overflow: hidden;
            }
            .header-banner::after {
                content: '';
                position: absolute;
                width: 200px;
                height: 200px;
                background: rgba(255, 255, 255, 0.08);
                border-radius: 50%;
                top: -80px;
                right: -40px;
                z-index: 1;
            }
            .header-banner-content {
                position: relative;
                z-index: 2;
            }
            .info-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }
            .student-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }
            .student-row {
                transition: all 0.2s ease;
            }
            .student-row:hover {
                background-color: rgba(253, 152, 0, 0.03) !important;
            }
            .status-radio-group {
                display: flex;
                gap: 10px;
                justify-content: center;
            }
            .status-radio-wrapper {
                position: relative;
            }
            .status-radio-wrapper input[type="radio"] {
                display: none;
            }
            .status-label {
                display: inline-block;
                padding: 6px 14px;
                font-weight: 700;
                font-size: 0.85rem;
                border-radius: 30px;
                border: 2px solid #ebedf2;
                cursor: pointer;
                transition: all 0.2s ease;
                text-align: center;
                min-width: 70px;
            }
            
            /* Status Hadir (H) - Green */
            .radio-hadir:checked + .label-hadir {
                background-color: #28a745;
                color: white;
                border-color: #28a745;
                box-shadow: 0 3px 8px rgba(40, 167, 69, 0.3);
            }
            .label-hadir:hover {
                border-color: #28a745;
                color: #28a745;
            }
            .radio-hadir:checked + .label-hadir:hover {
                color: white;
            }

            /* Status Sakit (S) - Blue */
            .radio-sakit:checked + .label-sakit {
                background-color: #17a2b8;
                color: white;
                border-color: #17a2b8;
                box-shadow: 0 3px 8px rgba(23, 162, 184, 0.3);
            }
            .label-sakit:hover {
                border-color: #17a2b8;
                color: #17a2b8;
            }
            .radio-sakit:checked + .label-sakit:hover {
                color: white;
            }

            /* Status Izin (I) - Orange/Yellow */
            .radio-izin:checked + .label-izin {
                background-color: #ffc107;
                color: white;
                border-color: #ffc107;
                box-shadow: 0 3px 8px rgba(255, 193, 7, 0.3);
            }
            .label-izin:hover {
                border-color: #ffc107;
                color: #ffc107;
            }
            .radio-izin:checked + .label-izin:hover {
                color: white;
            }

            /* Status Alpa (A) - Red */
            .radio-alpa:checked + .label-alpa {
                background-color: #dc3545;
                color: white;
                border-color: #dc3545;
                box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
            }
            .label-alpa:hover {
                border-color: #dc3545;
                color: #dc3545;
            }
            .radio-alpa:checked + .label-alpa:hover {
                color: white;
            }

            .input-keterangan {
                border-radius: 8px;
                border: 1px solid #ced4da;
                padding: 6px 12px;
                font-size: 0.88rem;
                width: 100%;
                max-width: 250px;
                transition: border-color 0.2s ease;
            }
            .input-keterangan:focus {
                border-color: #ff9800;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
            }
            .btn-save-attendance {
                background: linear-gradient(135deg, #ff9800 0%, #fd7e14 100%);
                border: none;
                color: white !important;
                font-weight: 600;
                border-radius: 30px !important;
                padding: 10px 24px;
                transition: all 0.25s ease;
            }
            .btn-save-attendance:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(253, 126, 20, 0.35) !important;
            }
        </style>
    </x-slot:myStyle>

    <!-- Top Banner -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card header-banner shadow-sm border-0 text-white p-4">
                <div class="header-banner-content d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <span class="badge bg-white-transparent text-white px-3 py-1.5 rounded-pill mb-2 font-weight-bold" style="background-color: rgba(255,255,255,0.15);">
                            <i class="fas fa-calendar-alt me-1"></i> Pencatatan Absensi
                        </span>
                        <h2 class="font-weight-bold mb-1">
                            {{ $ruanganKelas->kelas->nama ?? '-' }} - {{ $ruanganKelas->rombel->nama ?? '-' }}
                        </h2>
                        <p class="mb-0 opacity-90" style="font-size: 0.95rem;">
                            Tahun Ajaran {{ $ruanganKelas->tahun_ajaran ?? '-' }} • Semester {{ $ruanganKelas->semester->nama ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('dashboard.guru.absensi.index') }}" class="btn btn-light btn-round px-4 py-2 text-warning font-weight-bold shadow-sm" style="transition: all 0.2s;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card: Subject and Date -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body py-4">
                    <form action="{{ route('dashboard.guru.absensi.show', $ruanganKelas->id) }}" method="GET" id="form-absensi-filter">
                        <div class="row align-items-end g-3">
                            <div class="col-md-4">
                                <div class="form-group p-0 m-0">
                                    <label for="mata_pelajaran_id" class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-book text-warning me-1"></i> Pilih Mata Pelajaran
                                    </label>
                                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" onchange="this.form.submit()" style="border-radius: 8px;">
                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ $selectedSubjectId === $subject->id ? 'selected' : '' }}>
                                                {{ $subject->nama }} ({{ $subject->kode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group p-0 m-0">
                                    <label for="tanggal" class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-calendar-day text-warning me-1"></i> Tanggal
                                    </label>
                                    <input type="date" name="tanggal" id="tanggal" value="{{ $selectedDate }}" class="form-control" onchange="this.form.submit()" style="border-radius: 8px;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-wrap gap-3 justify-content-md-end text-md-end mt-3 mt-md-0" style="font-size: 0.88rem;">
                                    <div>
                                        <span class="text-secondary d-block font-weight-bold"><i class="fas fa-school me-1 text-muted"></i> Wali Kelas:</span>
                                        <span class="text-dark font-weight-bold">{{ $ruanganKelas->guru->nama_lengkap ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Board -->
    <div class="row">
        <div class="col-md-12">
            <div class="card student-card shadow-sm border-0">
                @if($selectedSubjectId === null)
                    <div class="card-body text-center py-5 text-muted">
                        <i class="fas fa-book-open fa-4x mb-3 text-secondary opacity-60"></i>
                        <h4 class="font-weight-bold text-dark">Mata Pelajaran Belum Dipilih</h4>
                        <p class="mb-0">Silakan pilih salah satu mata pelajaran yang Anda ajarkan di kelas ini pada panel di atas untuk menampilkan lembar absensi.</p>
                    </div>
                @else
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="font-weight-bold text-dark m-0">
                            <i class="fas fa-list-alt text-warning me-2"></i> Daftar Kehadiran Roster Siswa
                        </h5>
                        <span class="badge bg-warning-transparent text-warning px-3 py-1.5 rounded-pill font-weight-bold" style="background-color: rgba(255, 152, 0, 0.1);">
                            Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="card-body">
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                                <div class="d-flex">
                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                    <div>
                                        <h6 class="font-weight-bold mb-1">Terjadi kesalahan validasi:</h6>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('dashboard.guru.absensi.store', $ruanganKelas->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $selectedSubjectId }}">
                            <input type="hidden" name="tanggal" value="{{ $selectedDate }}">

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th class="text-start">Nama Siswa</th>
                                            <th style="width: 400px;">Status Kehadiran</th>
                                            <th>Catatan / Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rosterSheet as $index => $item)
                                            @php
                                                $student = $item['siswa'];
                                                $attendance = $item['attendance'];
                                                $currentStatus = old("attendance.{$index}.status", $attendance->status ?? 'Hadir');
                                                $currentKeterangan = old("attendance.{$index}.keterangan", $attendance->keterangan ?? '');
                                            @endphp
                                            <tr class="student-row">
                                                <td class="text-center font-weight-bold text-secondary">
                                                    {{ $index + 1 }}
                                                    <input type="hidden" name="attendance[{{ $index }}][siswa_id]" value="{{ $student->id }}">
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $student->nama_lengkap }}</div>
                                                    <small class="text-muted font-mono">NIS: {{ $student->nis ?? '-' }}</small>
                                                </td>
                                                <td>
                                                    <div class="status-radio-group">
                                                        <!-- Hadir -->
                                                        <div class="status-radio-wrapper">
                                                            <input type="radio" 
                                                                   name="attendance[{{ $index }}][status]" 
                                                                   id="status_hadir_{{ $student->id }}" 
                                                                   value="Hadir" 
                                                                   class="radio-hadir" 
                                                                   {{ $currentStatus === 'Hadir' ? 'checked' : '' }}>
                                                            <label for="status_hadir_{{ $student->id }}" class="status-label label-hadir">Hadir</label>
                                                        </div>

                                                        <!-- Sakit -->
                                                        <div class="status-radio-wrapper">
                                                            <input type="radio" 
                                                                   name="attendance[{{ $index }}][status]" 
                                                                   id="status_sakit_{{ $student->id }}" 
                                                                   value="Sakit" 
                                                                   class="radio-sakit" 
                                                                   {{ $currentStatus === 'Sakit' ? 'checked' : '' }}>
                                                            <label for="status_sakit_{{ $student->id }}" class="status-label label-sakit">Sakit</label>
                                                        </div>

                                                        <!-- Izin -->
                                                        <div class="status-radio-wrapper">
                                                            <input type="radio" 
                                                                   name="attendance[{{ $index }}][status]" 
                                                                   id="status_izin_{{ $student->id }}" 
                                                                   value="Izin" 
                                                                   class="radio-izin" 
                                                                   {{ $currentStatus === 'Izin' ? 'checked' : '' }}>
                                                            <label for="status_izin_{{ $student->id }}" class="status-label label-izin">Izin</label>
                                                        </div>

                                                        <!-- Alpa -->
                                                        <div class="status-radio-wrapper">
                                                            <input type="radio" 
                                                                   name="attendance[{{ $index }}][status]" 
                                                                   id="status_alpa_{{ $student->id }}" 
                                                                   value="Alpa" 
                                                                   class="radio-alpa" 
                                                                   {{ $currentStatus === 'Alpa' ? 'checked' : '' }}>
                                                            <label for="status_alpa_{{ $student->id }}" class="status-label label-alpa">Alpa</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" 
                                                           name="attendance[{{ $index }}][keterangan]" 
                                                           value="{{ $currentKeterangan }}" 
                                                           placeholder="Catatan (opsional)..." 
                                                           class="form-control input-keterangan mx-auto">
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted">
                                                    <i class="fas fa-users-slash fa-3x mb-2 d-block"></i> Tidak ada siswa yang aktif di kelas ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if(count($rosterSheet) > 0)
                                <div class="d-flex justify-content-end mt-4 border-top pt-3">
                                    <button type="submit" class="btn btn-save-attendance btn-round shadow-sm">
                                        <i class="fas fa-save me-2"></i> Simpan Absensi
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Halaman Riwayat Kehadiran Kumulatif (Summary) -->
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="font-weight-bold text-dark m-0">
                                <i class="fas fa-chart-line text-warning me-2"></i> Rekapitulasi Kehadiran Siswa (Akumulasi Semua Hari)
                            </h5>
                            <p class="text-muted m-0 mt-1" style="font-size: 0.85rem;">Total akumulasi kehadiran siswa untuk mata pelajaran ini di kelas {{ $ruanganKelas->kelas->nama }} - {{ $ruanganKelas->rombel->nama }}.</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th class="text-start">Nama Siswa</th>
                                            <th>Hadir (H)</th>
                                            <th>Sakit (S)</th>
                                            <th>Izin (I)</th>
                                            <th>Alpa (A)</th>
                                            <th>Total Hari</th>
                                            <th>Persentase Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rosterSheet as $index => $item)
                                            @php
                                                $student = $item['siswa'];
                                                $studentSummary = $attendanceSummary->get($student->id) ?? collect();
                                                
                                                $hadir = $studentSummary->firstWhere('status', 'Hadir')?->total ?? 0;
                                                $sakit = $studentSummary->firstWhere('status', 'Sakit')?->total ?? 0;
                                                $izin = $studentSummary->firstWhere('status', 'Izin')?->total ?? 0;
                                                $alpa = $studentSummary->firstWhere('status', 'Alpa')?->total ?? 0;
                                                
                                                $totalHari = $hadir + $sakit + $izin + $alpa;
                                                $percentage = $totalHari > 0 ? ($hadir / $totalHari) * 100 : 0;
                                            @endphp
                                            <tr>
                                                <td class="text-center font-weight-bold text-secondary">{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $student->nama_lengkap }}</div>
                                                    <small class="text-muted font-mono">NIS: {{ $student->nis ?? '-' }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-success text-white px-2.5 py-1.5 font-weight-bold" style="font-size: 0.85rem; border-radius: 6px;">{{ $hadir }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info text-white px-2.5 py-1.5 font-weight-bold" style="font-size: 0.85rem; border-radius: 6px;">{{ $sakit }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-warning text-white px-2.5 py-1.5 font-weight-bold" style="font-size: 0.85rem; border-radius: 6px;">{{ $izin }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-danger text-white px-2.5 py-1.5 font-weight-bold" style="font-size: 0.85rem; border-radius: 6px;">{{ $alpa }}</span>
                                                </td>
                                                <td class="text-center font-weight-bold text-dark">{{ $totalHari }} Hari</td>
                                                <td class="text-center">
                                                    @if($totalHari > 0)
                                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                                            <div class="progress w-100" style="height: 8px; max-width: 100px; border-radius: 10px; background-color: #ebedf2;">
                                                                <div class="progress-bar {{ $percentage >= 80 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                                     role="progressbar" 
                                                                     style="width: {{ $percentage }}%; border-radius: 10px;" 
                                                                     aria-valuenow="{{ $percentage }}" 
                                                                     aria-valuemin="0" 
                                                                     aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span class="font-weight-bold text-dark" style="font-size: 0.88rem;">{{ number_format($percentage, 1) }}%</span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted" style="font-size: 0.85rem;">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">Tidak ada data rekapitulasi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
