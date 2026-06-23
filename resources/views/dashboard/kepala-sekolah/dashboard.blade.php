<x-dashboard.layoutDashboard.app title="Dashboard Kepala Sekolah">
    <x-slot:myStyle>
        <style>
            .welcome-card {
                background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%);
                color: #ffffff;
                border-radius: 16px;
                border: none;
                position: relative;
                overflow: hidden;
            }

            .welcome-card::after {
                content: '';
                position: absolute;
                width: 250px;
                height: 250px;
                background: rgba(255, 255, 255, 0.15);
                border-radius: 50%;
                top: -60px;
                right: -60px;
                z-index: 1;
            }

            .welcome-card::before {
                content: '';
                position: absolute;
                width: 150px;
                height: 150px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                bottom: -40px;
                right: 80px;
                z-index: 1;
            }

            .welcome-content {
                position: relative;
                z-index: 2;
            }

            .stat-card {
                border-radius: 16px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid #ebedf2;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
            }

            .icon-wrapper {
                width: 54px;
                height: 54px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .chart-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }

            .theme-chart {
                min-height: 330px;
            }
        </style>
    </x-slot:myStyle>

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card welcome-card shadow-sm p-4">
                <div class="welcome-content py-2">
                    <h2 class="font-weight-bold mb-2">Selamat Datang Kepala Sekolah!</h2>
                    <p class="mb-0 opacity-80" style="font-size: 0.95rem;">
                        Panel pemantauan akademik sekolah. Di sini Anda dapat memantau indikator statistik, sebaran data siswa, serta jalannya kegiatan pembelajaran di sekolah secara berkala.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: 6 Core Dynamic Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Siswa -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-primary-light text-primary mx-auto mb-3"
                        style="background-color: rgba(21, 114, 232, 0.1);">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalSiswa }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Siswa</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Guru -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-success-light text-success mx-auto mb-3"
                        style="background-color: rgba(40, 167, 69, 0.1);">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalGuru }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Guru & Staf</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Mata Pelajaran -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-warning-light text-warning mx-auto mb-3"
                        style="background-color: rgba(255, 193, 7, 0.15);">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalMapel }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Mata Pelajaran</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Ruangan Kelas -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-info-light text-info mx-auto mb-3"
                        style="background-color: rgba(23, 162, 184, 0.1);">
                        <i class="fas fa-school fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalRuangan }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Kelas & Ruangan</p>
                </div>
            </div>
        </div>

        <!-- Card 5: Rombongan Belajar -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-danger-light text-danger mx-auto mb-3"
                        style="background-color: rgba(220, 53, 69, 0.1);">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalRombel }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Rombel</p>
                </div>
            </div>
        </div>

        <!-- Card 6: Jadwal Pelajaran -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-secondary-light text-secondary mx-auto mb-3"
                        style="background-color: rgba(108, 117, 125, 0.1);">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalJadwal }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Slot Jadwal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Dynamic Charts (ApexCharts) -->
    <div class="row g-4 mb-4">
        <!-- Left Chart: Status Keanggotaan Siswa (Spline Area / Column) -->
        <div class="col-lg-7">
            <div class="card chart-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-chart-area text-primary me-2"></i> Grafik Status Keanggotaan Siswa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div id="statusSiswaChart" class="theme-chart"></div>
                </div>
            </div>
        </div>

        <!-- Right Chart: Penyebaran Gender Siswa (Donut Chart) -->
        <div class="col-lg-5">
            <div class="card chart-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-chart-pie text-success me-2"></i> Sebaran Jenis Kelamin Siswa
                    </h5>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div id="genderSiswaChart" class="w-100 theme-chart" style="max-width: 380px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Pemantauan Nilai Siswa (Principal Read-Only Mode) -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card chart-card border-0 shadow-sm bg-white">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-search text-primary me-2"></i> Pemantauan Nilai Kelas & Rapor
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-end g-3 mb-4">
                        <div class="col-md-4">
                            <form action="{{ route('dashboard') }}" method="GET" id="form-filter-grades">
                                <label for="ruangan_kelas_id" class="form-label font-weight-bold text-dark">Pilih Kelas</label>
                                <select name="ruangan_kelas_id" id="ruangan_kelas_id" class="form-select" onchange="document.getElementById('mata_pelajaran_id_val').value = ''; this.form.submit()" style="border-radius: 8px;">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($classrooms as $c)
                                        <option value="{{ $c->id }}" {{ $selectedClassroomId === $c->id ? 'selected' : '' }}>
                                            {{ $c->kelas->nama }} - {{ $c->rombel->nama }} ({{ $c->semester->nama }} - {{ $c->tahun_ajaran }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="mata_pelajaran_id" id="mata_pelajaran_id_val" value="{{ $selectedSubjectId }}">
                            </form>
                        </div>
                        
                        @if($selectedClassroomId)
                            <div class="col-md-4">
                                <form action="{{ route('dashboard') }}" method="GET">
                                    <input type="hidden" name="ruangan_kelas_id" value="{{ $selectedClassroomId }}">
                                    <label for="mata_pelajaran_id" class="form-label font-weight-bold text-dark">Pilih Mata Pelajaran</label>
                                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" onchange="this.form.submit()" style="border-radius: 8px;">
                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                        @foreach($subjects as $subj)
                                            <option value="{{ $subj->id }}" {{ $selectedSubjectId === $subj->id ? 'selected' : '' }}>
                                                {{ $subj->nama }} ({{ $subj->kode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if($selectedClassroomId && $selectedSubjectId)
                        <!-- Grades View (Read-Only) -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">Formatif (F)</th>
                                        <th class="text-center">Sumatif LM</th>
                                        <th class="text-center">Sumatif Akhir (SAS)</th>
                                        <th class="text-center">Nilai Akhir (NA)</th>
                                        <th>Deskripsi Capaian Kompetensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gradesSheet as $idx => $g)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>
                                                <div class="font-weight-bold text-dark">{{ $g['siswa']->nama_lengkap }}</div>
                                                <div class="d-flex align-items-center flex-wrap gap-2 mt-1">
                                                    <small class="text-muted font-mono">NIS: {{ $g['siswa']->nis ?? '-' }}</small>
                                                    <button type="button" 
                                                            class="btn btn-link p-0 text-warning font-weight-bold d-inline-flex align-items-center" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalRevisiSiswa" 
                                                            data-siswa-nama="{{ $g['siswa']->nama_lengkap }}" 
                                                            data-siswa-nis="{{ $g['siswa']->nis ?? '-' }}"
                                                            style="font-size: 0.8rem; text-decoration: none; border: none; background: transparent; transition: opacity 0.2s;"
                                                            onmouseover="this.style.opacity='0.8'"
                                                            onmouseout="this.style.opacity='1'">
                                                        <span class="text-muted mx-1.5">•</span>
                                                        <i class="fas fa-exclamation-circle me-1" style="font-size: 0.85rem;"></i> Minta Revisi
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center font-weight-bold">{{ $g['nilai']->nilai_formatif ?? '-' }}</td>
                                            <td class="text-center font-weight-bold">{{ $g['nilai']->nilai_sumatif_materi ?? '-' }}</td>
                                            <td class="text-center font-weight-bold">{{ $g['nilai']->nilai_sumatif_akhir ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $g['nilai'] && $g['nilai']->nilai_akhir !== null ? 'bg-primary text-white' : 'bg-light text-dark' }} font-weight-bold px-3 py-1.5 rounded" style="font-size: 0.9rem;">
                                                    {{ $g['nilai'] && $g['nilai']->nilai_akhir !== null ? number_format($g['nilai']->nilai_akhir, 2) : '-' }}
                                                </span>
                                            </td>
                                            <td class="text-secondary" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $g['nilai']->keterangan ?? '' }}">
                                                {{ $g['nilai']->keterangan ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data nilai untuk mata pelajaran ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
            
                        <!-- Revision Message Panel -->
                        <div class="row g-4 border-top pt-4">
                            <!-- Left: Create Revision Request -->
                            <div class="col-md-6">
                                <div class="card border shadow-sm p-4 h-100" style="border-radius: 12px;">
                                    <h6 class="font-weight-bold text-dark mb-3">
                                        <i class="fas fa-paper-plane text-warning me-2"></i> Kirim Permintaan Revisi Nilai
                                    </h6>
                                    <form action="{{ route('dashboard.kepala-sekolah.revisi.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ruangan_kelas_id" value="{{ $selectedClassroomId }}">
                                        <input type="hidden" name="mata_pelajaran_id" value="{{ $selectedSubjectId }}">
                                        
                                        <div class="form-group p-0 mb-3">
                                            <label for="pesan" class="form-label font-weight-bold text-secondary mb-2">Pesan / Catatan Revisi</label>
                                            <textarea name="pesan" id="pesan" rows="3" class="form-control" placeholder="Tulis instruksi revisi nilai, misal: Mohon periksa kembali nilai formatif Budi..." required style="border-radius: 8px;"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-warning btn-round font-weight-bold px-4 text-white">
                                            <i class="fas fa-paper-plane me-1"></i> Kirim ke Guru
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Right: Revisions History -->
                            <div class="col-md-6">
                                <div class="card border shadow-sm p-4 h-100" style="border-radius: 12px; max-height: 300px; overflow-y: auto;">
                                    <h6 class="font-weight-bold text-dark mb-3">
                                        <i class="fas fa-history text-secondary me-2"></i> Riwayat Revisi
                                    </h6>
                                    @forelse($revisions as $rev)
                                        <div class="border-bottom py-3 {{ $loop->last ? 'border-0' : '' }}">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="badge {{ $rev->status === 'Pending' ? 'bg-warning text-white' : 'bg-success text-white' }} px-2 py-1" style="font-size: 0.75rem;">
                                                    {{ $rev->status }}
                                                </span>
                                                <small class="text-muted font-mono" style="font-size: 0.8rem;">{{ $rev->created_at }}</small>
                                            </div>
                                            <p class="mb-0 text-secondary" style="font-size: 0.88rem;">"{{ $rev->pesan }}"</p>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-comment-slash fa-2x mb-2 d-block opacity-50"></i> Belum ada riwayat revisi untuk mata pelajaran ini.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Modal Revisi Nilai Siswa -->
                        <div class="modal fade" id="modalRevisiSiswa" tabindex="-1" aria-labelledby="modalRevisiSiswaLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #ffa100 0%, #ffc107 100%); border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                                        <h5 class="modal-title font-weight-bold" id="modalRevisiSiswaLabel">
                                            <i class="fas fa-exclamation-circle me-2"></i> Minta Revisi Nilai Siswa
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('dashboard.kepala-sekolah.revisi.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ruangan_kelas_id" value="{{ $selectedClassroomId }}">
                                        <input type="hidden" name="mata_pelajaran_id" value="{{ $selectedSubjectId }}">
                                        
                                        <div class="modal-body p-4">
                                            <div class="mb-3 p-3 bg-light rounded" style="border-left: 4px solid #ffc107;">
                                                <div class="font-weight-bold text-dark mb-1" style="font-size: 0.95rem;">Informasi Kelas & Siswa:</div>
                                                <div class="text-secondary" style="font-size: 0.88rem; line-height: 1.6;">
                                                    <strong>Siswa:</strong> <span id="modal-siswa-info" class="text-dark font-weight-bold">-</span><br>
                                                    <strong>Kelas:</strong> {{ $classrooms->firstWhere('id', $selectedClassroomId)?->kelas?->nama }} - {{ $classrooms->firstWhere('id', $selectedClassroomId)?->rombel?->nama }}<br>
                                                    <strong>Mata Pelajaran:</strong> {{ $subjects->firstWhere('id', $selectedSubjectId)?->nama }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group p-0 mb-0">
                                                <label for="modal-pesan" class="form-label font-weight-bold text-dark mb-2">Pesan / Catatan Instruksi Revisi</label>
                                                <textarea name="pesan" id="modal-pesan" rows="4" class="form-control" placeholder="Tulis catatan detail mengenai perbaikan nilai siswa ini..." required style="border-radius: 10px; font-size: 0.9rem; border: 1px solid #ced4da; padding: 10px 14px;"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer border-0 pt-0 px-4 pb-4">
                                            <button type="button" class="btn btn-light font-weight-bold px-4" data-bs-dismiss="modal" style="border-radius: 30px;">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white font-weight-bold px-4 shadow-sm" style="border-radius: 30px; background: linear-gradient(135deg, #ffa100 0%, #ffc107 100%); border: none;">
                                                <i class="fas fa-paper-plane me-1"></i> Kirim ke Guru
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        @if($selectedClassroomId)
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-book-open fa-2x mb-2 d-block opacity-50"></i> Silakan pilih mata pelajaran untuk menampilkan nilai.
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-school fa-2x mb-2 d-block opacity-50"></i> Silakan pilih kelas terlebih dahulu untuk melihat pemantauan nilai.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script Block -->
    <x-slot:myScript>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Modal Event Listener for Student Grade Revision
                const modalRevisiSiswa = document.getElementById('modalRevisiSiswa');
                if (modalRevisiSiswa) {
                    modalRevisiSiswa.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const nama = button.getAttribute('data-siswa-nama');
                        const nis = button.getAttribute('data-siswa-nis');
                        
                        const modalSiswaInfo = modalRevisiSiswa.querySelector('#modal-siswa-info');
                        const modalPesan = modalRevisiSiswa.querySelector('#modal-pesan');
                        
                        modalSiswaInfo.textContent = `${nama} (NIS: ${nis})`;
                        modalPesan.value = `Mohon merevisi nilai untuk siswa ${nama} (NIS: ${nis}) pada mata pelajaran ini karena: \n- [Tulis alasan...]`;
                        
                        setTimeout(() => {
                            modalPesan.focus();
                            const startIdx = modalPesan.value.indexOf('[Tulis alasan...]');
                            if (startIdx !== -1) {
                                modalPesan.setSelectionRange(startIdx, startIdx + '[Tulis alasan...]'.length);
                            }
                        }, 400);
                    });
                }

                // 1. Gender Donut Chart
                var genderLabels = @json($genderData->pluck('name'));
                var genderTotals = @json($genderData->pluck('total')->map(fn($v) => (int) $v));

                var genderOptions = {
                    series: genderTotals.length > 0 ? genderTotals : [0],
                    labels: genderLabels.length > 0 ? genderLabels : ["Tidak Ada Data"],
                    chart: {
                        type: 'donut',
                        height: 330,
                        fontFamily: 'inherit'
                    },
                    colors: ['#007bff', '#e83e8c', '#fd7e14', '#28a745'],
                    legend: {
                        position: 'bottom',
                        fontSize: '12px'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '14px',
                                        fontWeight: 600
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '20px',
                                        fontWeight: 700,
                                        formatter: function(val) {
                                            return val + " Siswa";
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total Siswa',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + " Siswa";
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
                var genderChart = new ApexCharts(document.querySelector("#genderSiswaChart"), genderOptions);
                genderChart.render();

                // 2. Status Area Chart
                var statusLabels = @json($statusData->pluck('name'));
                var statusTotals = @json($statusData->pluck('total')->map(fn($v) => (int) $v));

                var statusOptions = {
                    series: [{
                        name: 'Jumlah Siswa',
                        data: statusTotals.length > 0 ? statusTotals : [0]
                    }],
                    chart: {
                        type: 'area',
                        height: 330,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit'
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    colors: ['#1171ef'],
                    xaxis: {
                        categories: statusLabels.length > 0 ? statusLabels : ["Tidak Ada Data"],
                        labels: {
                            style: {
                                fontWeight: 500
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return Math.round(val);
                            }
                        }
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " Siswa";
                            }
                        }
                    }
                };
                var statusChart = new ApexCharts(document.querySelector("#statusSiswaChart"), statusOptions);
                statusChart.render();
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
