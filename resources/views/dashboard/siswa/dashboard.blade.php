<x-dashboard.layoutDashboard.app title="Dashboard Siswa">
    <x-slot:myStyle>
        <style>
            .welcome-card {
                background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%);
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

            .student-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }

            .classmate-avatar {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                object-cover;
                background-color: #f8f9fa;
                border: 2px solid #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
        </style>
    </x-slot:myStyle>

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card welcome-card shadow-sm p-4">
                <div class="welcome-content py-2">
                    <h2 class="font-weight-bold mb-2">Hai, {{ $siswa->nama_lengkap ?? $user->name }}!</h2>
                    <p class="mb-0 opacity-80" style="font-size: 0.95rem;">
                        Selamat datang di portal akademik siswa. Lihat jadwal pelajaran harianmu, teman-teman sekelasmu, dan kelola proses belajarmu dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Student Information & Summary Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Kelas -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-primary-light text-primary mx-auto mb-3"
                        style="background-color: rgba(21, 114, 232, 0.1); color: #1572e8;">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.4rem;">
                        {{ $anggotaKelasActive ? ($anggotaKelasActive->ruanganKelas->kelas->nama . ' - ' . $anggotaKelasActive->ruanganKelas->rombel->nama) : 'Belum Ditentukan' }}
                    </h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Kelas Anda</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Wali Kelas -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-success-light text-success mx-auto mb-3"
                        style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.1rem; line-height: 1.4;">
                        {{ $anggotaKelasActive->ruanganKelas->guru->nama_lengkap ?? 'Tidak Ada' }}
                    </h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Wali Kelas</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Teman Sekelas -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-warning-light text-warning mx-auto mb-3"
                        style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $temanSekelas->count() }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Teman Sekelas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Jadwal Pelajaran & Daftar Teman Sekelas -->
    <div class="row g-4 mb-4">
        <!-- Left: Jadwal Pelajaran -->
        <div class="col-lg-7">
            <div class="card student-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-calendar-alt text-primary me-2"></i> Jadwal Pelajaran Anda
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
                                    <th>Guru</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwalPelajaran as $jadwal)
                                    <tr>
                                        <td><span class="badge bg-secondary text-white">{{ $jadwal->hari }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                        <td class="font-weight-bold text-dark">{{ $jadwal->mataPelajaran->nama ?? '-' }}</td>
                                        <td>{{ $jadwal->guru->nama_lengkap ?? '-' }}</td>
                                        <td><span class="badge bg-info-light text-info">{{ $jadwal->ruangan ?? 'Kelas' }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i> Tidak ada jadwal pelajaran terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Teman Sekelas -->
        <div class="col-lg-5">
            <div class="card student-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-users text-success me-2"></i> Teman Sekelas Anda
                    </h5>
                </div>
                <div class="card-body p-4" style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @forelse($temanSekelas as $teman)
                            <li class="list-group-item d-flex align-items-center justify-content-between px-0 py-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    @php
                                        $avatar = $teman->siswa->foto ? asset('storage/' . $teman->siswa->foto) : ($teman->siswa->jenisKelamin && $teman->siswa->jenisKelamin->nama === 'Perempuan' ? 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=100&auto=format&fit=crop' : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=100&auto=format&fit=crop');
                                    @endphp
                                    <img src="{{ $avatar }}" alt="Foto {{ $teman->siswa->nama_lengkap }}" class="classmate-avatar me-3">
                                    <div>
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ $teman->siswa->nama_lengkap }}</h6>
                                        <small class="text-muted">NIS. {{ $teman->siswa->nis ?? '-' }}</small>
                                    </div>
                                </div>
                                <span class="badge rounded-pill bg-light text-muted border px-2.5 py-1">
                                    {{ $teman->siswa->jenisKelamin->nama ?? '-' }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted border-0">
                                <i class="fas fa-user-slash fa-2x mb-2 d-block"></i> Belum ada teman sekelas terdaftar.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
