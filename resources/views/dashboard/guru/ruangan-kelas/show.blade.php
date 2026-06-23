<x-dashboard.layoutDashboard.app title="Detail Ruangan Kelas">
    <x-slot:myStyle>
        <style>
            .header-banner {
                background: linear-gradient(135deg, #1572e8 0%, #064fa9 100%);
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
            .info-list-item {
                border-bottom: 1px solid #f1f2f5;
                padding: 14px 0;
            }
            .info-list-item:last-child {
                border-bottom: none;
            }
            .student-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }
            .student-row {
                transition: all 0.2s ease;
            }
            .student-row:hover {
                background-color: rgba(21, 114, 232, 0.04) !important;
            }
            .btn-view-profile {
                border-color: #1572e8;
                color: #1572e8;
                font-weight: 600;
                border-radius: 30px !important;
                background-color: transparent;
                transition: all 0.2s ease-in-out;
            }
            .btn-view-profile:hover {
                background-color: #1572e8;
                color: #ffffff !important;
                transform: translateY(-1px);
                box-shadow: 0 4px 10px rgba(21, 114, 232, 0.2);
            }
            .btn-back {
                border-radius: 30px !important;
                font-weight: 600;
                transition: all 0.2s;
            }
            .btn-back:hover {
                transform: translateX(-3px);
            }
        </style>
    </x-slot:myStyle>

    <!-- Top Banner Summary -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card header-banner shadow-sm border-0 text-white p-4">
                <div class="header-banner-content py-2">
                    <span class="badge bg-white-transparent text-white px-3 py-1.5 rounded-pill mb-2 font-weight-bold" style="background-color: rgba(255,255,255,0.15);">
                        <i class="fas fa-university me-1"></i> Detail Ruangan Kelas
                    </span>
                    <h2 class="font-weight-bold mb-1">
                        {{ $ruanganKelas->kelas->nama ?? '-' }} - {{ $ruanganKelas->rombel->nama ?? '-' }}
                    </h2>
                    <p class="mb-0 opacity-90" style="font-size: 0.95rem;">
                        Tahun Ajaran {{ $ruanganKelas->tahun_ajaran ?? '-' }} • Semester {{ $ruanganKelas->semester->nama ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Classroom Meta Details -->
        <div class="col-md-4">
            <div class="card info-card shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="font-weight-bold text-dark m-0">
                        <i class="fas fa-info-circle text-primary me-2"></i> Informasi Kelas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="info-list-item d-flex justify-content-between align-items-center">
                            <span class="text-secondary font-weight-bold"><i class="fas fa-school me-2 text-muted"></i>Kelas & Rombel</span>
                            <span class="text-dark font-weight-bold">{{ $ruanganKelas->kelas->nama ?? '-' }} - {{ $ruanganKelas->rombel->nama ?? '-' }}</span>
                        </div>
                        <div class="info-list-item d-flex justify-content-between align-items-center">
                            <span class="text-secondary font-weight-bold"><i class="fas fa-chalkboard-teacher me-2 text-muted"></i>Wali Kelas</span>
                            <span class="text-dark font-weight-bold">{{ $ruanganKelas->guru->nama_lengkap ?? '-' }}</span>
                        </div>
                        <div class="info-list-item d-flex justify-content-between align-items-center">
                            <span class="text-secondary font-weight-bold"><i class="fas fa-book-open me-2 text-muted"></i>Semester</span>
                            <span class="text-dark">{{ $ruanganKelas->semester->nama ?? '-' }}</span>
                        </div>
                        <div class="info-list-item d-flex justify-content-between align-items-center">
                            <span class="text-secondary font-weight-bold"><i class="fas fa-calendar-alt me-2 text-muted"></i>Tahun Angkatan</span>
                            <span class="text-dark">{{ $ruanganKelas->tahun_angkatan ?? '-' }}</span>
                        </div>
                        <div class="info-list-item d-flex justify-content-between align-items-center">
                            <span class="text-secondary font-weight-bold"><i class="fas fa-history me-2 text-muted"></i>Tahun Ajaran</span>
                            <span class="text-dark">{{ $ruanganKelas->tahun_ajaran ?? '-' }}</span>
                        </div>
                        <div class="info-list-item d-flex justify-content-between align-items-center">
                            <span class="text-secondary font-weight-bold"><i class="fas fa-users me-2 text-muted"></i>Total Siswa</span>
                            <span class="badge bg-primary text-white font-weight-bold px-3 py-1.5 rounded-pill">{{ $ruanganKelas->anggotaKelas->count() }} Siswa</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('dashboard.guru.ruangan-kelas.index') }}" class="btn btn-secondary btn-back btn-round w-100 py-2.5">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Roster List -->
        <div class="col-md-8">
            <div class="card student-card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="font-weight-bold text-dark m-0">
                        <i class="fas fa-user-graduate text-success me-2"></i> Daftar Siswa Terdaftar
                    </h5>
                    <!-- Quick Client-side Search -->
                    <div class="position-relative">
                        <input type="text" id="search-siswa-show" class="form-control form-control-sm" placeholder="Cari nama, NIS, status..." style="width: 250px; border-radius: 20px; padding-left: 35px; border: 1px solid #ced4da; height: 35px;">
                        <span class="position-absolute text-muted" style="left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="student-roster-rows">
                                @forelse($ruanganKelas->anggotaKelas as $index => $anggota)
                                    <tr class="student-row">
                                        <td class="text-secondary font-weight-bold">{{ $index + 1 }}</td>
                                        <td class="font-mono">{{ $anggota->siswa->nis ?? '-' }}</td>
                                        <td class="font-mono text-muted">{{ $anggota->siswa->nisn ?? '-' }}</td>
                                        <td class="font-weight-bold text-dark">{{ $anggota->siswa->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $anggota->siswa->jenisKelamin->nama ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $anggota->siswa->status === 'Aktif' ? 'bg-success' : 'bg-danger' }} text-white px-2.5 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                                                <i class="fas {{ $anggota->siswa->status === 'Aktif' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                                {{ $anggota->siswa->status ?? 'Aktif' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.guru.siswa.show', $anggota->siswa->id) }}" class="btn btn-sm btn-outline-primary btn-view-profile px-3">
                                                <i class="fas fa-id-card me-1"></i> Profil
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-user-slash fa-3x mb-2 d-block"></i> Belum ada siswa yang terdaftar di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:myScript>
        <script>
            jQuery(function($) {
                // Instantly filter roster table based on search input
                $('#search-siswa-show').on('keyup', function() {
                    var query = $(this).val().toLowerCase();
                    $('#student-roster-rows tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
                    });
                });
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
