<x-dashboard.layoutDashboard.app title="Hasil Nilai">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title text-dark font-weight-bold">
                <i class="fas fa-file-invoice text-primary me-2"></i> Riwayat Hasil Belajar Anda
            </h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4" style="background-color: rgba(21, 114, 232, 0.08); color: #1572e8;">
                <h6 class="font-weight-bold mb-2">
                    <i class="fa fa-info-circle me-2"></i> Selamat datang, {{ $siswa->nama_lengkap }}!
                </h6>
                <p class="m-0 fs-7">
                    Di bawah ini adalah daftar riwayat kelas dan rombel yang pernah atau sedang Anda tempati. Klik tombol <strong>Lihat Nilai</strong> pada kolom Aksi untuk memuat detail biodata diri, pencapaian mata pelajaran, dan status absensi per semester.
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;" class="text-center">No</th>
                            <th>Kelas & Rombel</th>
                            <th>Wali Kelas</th>
                            <th class="text-center">Tahun Angkatan</th>
                            <th class="text-center">Tahun Ajaran</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Status</th>
                            <th style="width: 150px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classHistory as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-secondary">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $item['kelas']->nama }}</div>
                                    <small class="text-muted font-mono">Rombel: {{ $item['rombel']->nama }}</small>
                                </td>
                                <td>
                                    <div class="text-dark font-weight-bold">{{ $item['guru']->nama_lengkap ?? '-' }}</div>
                                    @if($item['guru']->nip)
                                        <small class="text-muted font-mono">NIP. {{ $item['guru']->nip }}</small>
                                    @endif
                                </td>
                                <td class="text-center font-mono">{{ $item['tahun_angkatan'] }}</td>
                                <td class="text-center font-mono font-weight-bold text-primary">{{ $item['tahun_ajaran'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border font-weight-bold">{{ $item['semesters'] }}</span>
                                </td>
                                <td class="text-center">
                                    @if($item['status'] === 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($item['status'] === 'Lulus')
                                        <span class="badge bg-primary">Lulus</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item['status'] }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('dashboard.siswa.nilai.show', $item['ruangan_kelas_id']) }}" class="btn btn-primary btn-sm btn-round shadow-sm px-3">
                                        <i class="fa fa-eye me-1"></i> Lihat Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-2 d-block text-secondary"></i>
                                    Anda belum terdaftar di ruangan kelas manapun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
