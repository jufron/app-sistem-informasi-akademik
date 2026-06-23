<x-dashboard.layoutDashboard.app title="Dashboard Guru">
    <x-slot:myStyle>
        <style>
            .welcome-card {
                background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%);
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

            .dashboard-list-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }
        </style>
    </x-slot:myStyle>

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card welcome-card shadow-sm p-4">
                <div class="welcome-content py-2">
                    <h2 class="font-weight-bold mb-2">Selamat Datang Kembali, {{ $guru->nama_lengkap ?? $user->name }}!</h2>
                    <p class="mb-0 opacity-80" style="font-size: 0.95rem;">
                        Panel manajemen kelas dan mengajar. Pantau jadwal pelajaran harian Anda, kelola mata pelajaran, dan lihat data siswa perwalian Anda secara real-time.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Core Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Wali Kelas Class Name -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-primary-light text-primary mx-auto mb-3"
                        style="background-color: rgba(21, 114, 232, 0.1);">
                        <i class="fas fa-id-card fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.3rem;">
                        {{ $ruanganWali ? ($ruanganWali->kelas->nama . ' - ' . $ruanganWali->rombel->nama) : 'Bukan Wali Kelas' }}
                    </h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Status Perwalian</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Siswa Perwalian -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-success-light text-success mx-auto mb-3"
                        style="background-color: rgba(40, 167, 69, 0.1);">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalSiswaWali }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Siswa Perwalian</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Mapel Diajar -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-warning-light text-warning mx-auto mb-3"
                        style="background-color: rgba(255, 193, 7, 0.15);">
                        <i class="fas fa-book-reader fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalMapelAjar }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Mata Pelajaran Diajar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Permintaan Revisi Nilai dari Kepala Sekolah (Jika ada) -->
    @if(isset($revisionsPending) && $revisionsPending->isNotEmpty())
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 16px; background-color: #fff8eb; border-left: 5px solid #ffa100 !important;">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="card-title text-warning font-weight-bold m-0 d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i> Perlu Tindakan: Permintaan Revisi Nilai dari Kepala Sekolah
                        </h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="row g-3">
                            @foreach($revisionsPending as $revisi)
                                <div class="col-md-12">
                                    <div class="p-3 bg-white rounded-3 border d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div>
                                            <span class="badge bg-warning text-white font-weight-bold mb-2">Revisi Pending</span>
                                            <h6 class="font-weight-bold text-dark mb-1">
                                                Kelas: {{ $revisi->ruanganKelas->kelas->nama }} - {{ $revisi->ruanganKelas->rombel->nama }} • Mapel: {{ $revisi->mataPelajaran->nama }}
                                            </h6>
                                            <p class="text-secondary mb-0" style="font-size: 0.9rem;">
                                                Catatan: "{{ $revisi->pesan }}"
                                            </p>
                                            <small class="text-muted d-block mt-1">Dikirim pada: {{ $revisi->created_at }}</small>
                                        </div>
                                        <div>
                                            <a href="{{ route('dashboard.guru.penilaian.show', ['ruanganKelas' => $revisi->ruangan_kelas_id, 'mata_pelajaran_id' => $revisi->mata_pelajaran_id]) }}" class="btn btn-warning btn-sm text-white font-weight-bold px-4 py-2" style="border-radius: 20px;">
                                                <i class="fas fa-edit me-1"></i> Buka Lembar Nilai
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Section: Pelajaran yang Diajar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card dashboard-list-card border-0 shadow-sm bg-white">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-book text-warning me-2"></i> Mata Pelajaran yang Anda Ajarkan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @forelse($mataPelajaran as $mapel)
                            <div class="col-md-3 col-sm-6">
                                <div class="p-3 border rounded-3 d-flex align-items-center bg-light">
                                    <div class="icon-wrapper bg-warning text-white me-3" style="width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ $mapel->nama }}</h6>
                                        <small class="text-muted">Kode: {{ $mapel->kode ?? '-' }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-3">
                                Belum ada mata pelajaran terdaftar yang diajarkan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Jadwal Pelajaran & Siswa Perwalian -->
    <div class="row g-4 mb-4">
        <!-- Left: Jadwal Pelajaran -->
        <div class="col-lg-6">
            <div class="card dashboard-list-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i> Jadwal Mengajar Anda
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwalPelajaran as $jadwal)
                                    <tr>
                                        <td><span class="badge bg-secondary text-white">{{ $jadwal->hari }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                        <td class="font-weight-bold">{{ $jadwal->mataPelajaran->nama ?? '-' }}</td>
                                        <td>{{ $jadwal->kelas->nama ?? '-' }} - {{ $jadwal->rombel->nama ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i> Belum ada jadwal mengajar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Daftar Siswa Perwalian -->
        <div class="col-lg-6">
            <div class="card dashboard-list-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-users text-success me-2"></i> Siswa Kelas Perwalian
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggotaSiswa as $anggota)
                                    <tr>
                                        <td>{{ $anggota->siswa->nis ?? '-' }}</td>
                                        <td class="font-weight-bold">
                                            <a href="{{ route('dashboard.guru.siswa.show', $anggota->siswa->id) }}" class="text-primary hover:underline">
                                                {{ $anggota->siswa->nama_lengkap ?? '-' }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge {{ $anggota->siswa->status === 'Aktif' ? 'bg-success' : 'bg-danger' }} text-white">
                                                {{ $anggota->siswa->status ?? 'Aktif' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            <i class="fas fa-user-slash fa-2x mb-2 d-block"></i> Tidak ada siswa terdaftar atau Anda bukan Wali Kelas.
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
</x-dashboard.layoutDashboard.app>
