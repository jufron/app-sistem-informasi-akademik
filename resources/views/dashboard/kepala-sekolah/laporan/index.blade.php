<x-dashboard.layoutDashboard.app title="Laporan Akademik Sekolah">
    <x-slot:myStyle>
        <style>
            .laporan-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }
            .nav-pills .nav-link {
                color: #495057;
                font-weight: 600;
                border-radius: 30px;
                padding: 10px 20px;
                transition: all 0.2s ease;
            }
            .nav-pills .nav-link.active {
                background: linear-gradient(135deg, #1572e8 0%, #064fa9 100%);
                color: white;
                box-shadow: 0 4px 10px rgba(21, 114, 232, 0.25);
            }
            .btn-cetak {
                border-radius: 30px !important;
                font-weight: 600;
                transition: all 0.25s;
            }
            .btn-cetak:hover {
                transform: translateY(-1.5px);
            }
        </style>
    </x-slot:myStyle>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card p-4 border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #1572e8 0%, #064fa9 100%); border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="font-weight-bold mb-1"><i class="fas fa-file-alt me-2"></i> Pusat Laporan Akademik</h2>
                        <p class="mb-0 opacity-90" style="font-size: 0.95rem;">Ekspor atau cetak seluruh data administratif dan penilaian sekolah secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="row">
        <div class="col-md-12">
            <div class="card laporan-card shadow-sm bg-white p-4">
                <!-- Navigation Tabs -->
                <ul class="nav nav-pills nav-secondary mb-4 gap-2" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') === 'penilaian' || !request('tab') ? 'active' : '' }}" id="pills-penilaian-tab" data-bs-toggle="pill" data-bs-target="#pills-penilaian" type="button" role="tab">
                            <i class="fas fa-star-half-alt me-1"></i> Laporan Penilaian
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') === 'siswa' ? 'active' : '' }}" id="pills-siswa-tab" data-bs-toggle="pill" data-bs-target="#pills-siswa" type="button" role="tab">
                            <i class="fas fa-user-graduate me-1"></i> Laporan Siswa
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') === 'guru' ? 'active' : '' }}" id="pills-guru-tab" data-bs-toggle="pill" data-bs-target="#pills-guru" type="button" role="tab">
                            <i class="fas fa-chalkboard-teacher me-1"></i> Laporan Guru
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') === 'kelas' ? 'active' : '' }}" id="pills-kelas-tab" data-bs-toggle="pill" data-bs-target="#pills-kelas" type="button" role="tab">
                            <i class="fas fa-school me-1"></i> Laporan Ruangan Kelas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') === 'mapel' ? 'active' : '' }}" id="pills-mapel-tab" data-bs-toggle="pill" data-bs-target="#pills-mapel" type="button" role="tab">
                            <i class="fas fa-book me-1"></i> Laporan Mata Pelajaran
                        </button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="pills-tabContent">
                    <!-- Tab 1: Penilaian -->
                    <div class="tab-pane fade show {{ request('tab') === 'penilaian' || !request('tab') ? 'active' : '' }}" id="pills-penilaian" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="font-weight-bold text-dark m-0"><i class="fas fa-edit text-primary me-1"></i> Filter Laporan Penilaian</h5>
                            @if($selectedClassroomId && $selectedSubjectId && count($gradesSheet) > 0)
                                <a href="{{ route('dashboard.kepala-sekolah.laporan.print-penilaian', ['ruangan_kelas_id' => $selectedClassroomId, 'mata_pelajaran_id' => $selectedSubjectId]) }}" target="_blank" class="btn btn-primary btn-cetak px-4 py-2 shadow-sm">
                                    <i class="fas fa-print me-1"></i> Cetak Laporan Nilai
                                </a>
                            @endif
                        </div>
                        
                        <div class="row align-items-end g-3 mb-4 border-bottom pb-4">
                            <div class="col-md-4">
                                <form action="{{ route('dashboard.kepala-sekolah.laporan.index') }}" method="GET">
                                    <input type="hidden" name="tab" value="penilaian">
                                    <label for="ruangan_kelas_id" class="form-label font-weight-bold text-secondary">Pilih Kelas</label>
                                    <select name="ruangan_kelas_id" id="laporan_ruangan_kelas_id" class="form-select" onchange="document.getElementById('laporan_mapel_id_val').value = ''; this.form.submit()" style="border-radius: 8px;">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($classrooms as $c)
                                            <option value="{{ $c->id }}" {{ $selectedClassroomId === $c->id ? 'selected' : '' }}>
                                                {{ $c->kelas->nama }} - {{ $c->rombel->nama }} ({{ $c->semester->nama }} - {{ $c->tahun_ajaran }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="mata_pelajaran_id" id="laporan_mapel_id_val" value="{{ $selectedSubjectId }}">
                                </form>
                            </div>
                            @if($selectedClassroomId)
                                <div class="col-md-4">
                                    <form action="{{ route('dashboard.kepala-sekolah.laporan.index') }}" method="GET">
                                        <input type="hidden" name="tab" value="penilaian">
                                        <input type="hidden" name="ruangan_kelas_id" value="{{ $selectedClassroomId }}">
                                        <label for="mata_pelajaran_id" class="form-label font-weight-bold text-secondary">Pilih Mata Pelajaran</label>
                                        <select name="mata_pelajaran_id" id="laporan_mata_pelajaran_id" class="form-select" onchange="this.form.submit()" style="border-radius: 8px;">
                                            <option value="">-- Pilih Mata Pelajaran --</option>
                                            @foreach($assessmentSubjects as $subj)
                                                <option value="{{ $subj->id }}" {{ $selectedSubjectId === $subj->id ? 'selected' : '' }}>
                                                    {{ $subj->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            @endif
                        </div>

                        @if($selectedClassroomId && $selectedSubjectId)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle border">
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
                                                    <small class="text-muted">NIS: {{ $g['siswa']->nis ?? '-' }}</small>
                                                </td>
                                                <td class="text-center font-weight-bold">{{ $g['nilai']->nilai_formatif ?? '-' }}</td>
                                                <td class="text-center font-weight-bold">{{ $g['nilai']->nilai_sumatif_materi ?? '-' }}</td>
                                                <td class="text-center font-weight-bold">{{ $g['nilai']->nilai_sumatif_akhir ?? '-' }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary text-white px-3 py-1.5 rounded">
                                                        {{ $g['nilai'] && $g['nilai']->nilai_akhir !== null ? number_format($g['nilai']->nilai_akhir, 2) : '-' }}
                                                    </span>
                                                </td>
                                                <td>{{ $g['nilai']->keterangan ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data nilai.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-search-plus fa-3x mb-2 d-block opacity-50"></i> Silakan pilih Kelas dan Mata Pelajaran di atas untuk menampilkan dan mencetak nilai.
                            </div>
                        @endif
                    </div>

                    <!-- Tab 2: Siswa -->
                    <div class="tab-pane fade show {{ request('tab') === 'siswa' ? 'active' : '' }}" id="pills-siswa" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="font-weight-bold text-dark m-0"><i class="fas fa-user-graduate text-primary me-1"></i> Data Siswa Terdaftar</h5>
                            <a href="{{ route('dashboard.kepala-sekolah.laporan.print-siswa') }}" target="_blank" class="btn btn-primary btn-cetak px-4 py-2 shadow-sm">
                                <i class="fas fa-print me-1"></i> Cetak Laporan Siswa
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>NIS</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Agama</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $idx => $s)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td class="font-mono">{{ $s->nis ?? '-' }}</td>
                                            <td class="font-mono text-muted">{{ $s->nisn ?? '-' }}</td>
                                            <td class="font-weight-bold text-dark">{{ $s->nama_lengkap }}</td>
                                            <td>{{ $s->jenisKelamin->nama ?? '-' }}</td>
                                            <td>{{ $s->agama->nama ?? '-' }}</td>
                                            <td>
                                                <span class="badge {{ $s->status === 'Aktif' ? 'bg-success' : 'bg-danger' }} text-white">
                                                    {{ $s->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3: Guru -->
                    <div class="tab-pane fade show {{ request('tab') === 'guru' ? 'active' : '' }}" id="pills-guru" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="font-weight-bold text-dark m-0"><i class="fas fa-chalkboard-teacher text-primary me-1"></i> Data Tenaga Pendidik</h5>
                            <a href="{{ route('dashboard.kepala-sekolah.laporan.print-guru') }}" target="_blank" class="btn btn-primary btn-cetak px-4 py-2 shadow-sm">
                                <i class="fas fa-print me-1"></i> Cetak Laporan Guru
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>NIP</th>
                                        <th>Nama Lengkap</th>
                                        <th>Spesialisasi Mata Pelajaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $idx => $t)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td class="font-mono">{{ $t->nip ?? '-' }}</td>
                                            <td class="font-weight-bold text-dark">{{ $t->nama_lengkap }}</td>
                                            <td>
                                                @foreach($t->mataPelajaran as $m)
                                                    <span class="badge bg-secondary text-white mr-1">{{ $m->nama }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <span class="badge bg-success text-white">{{ $t->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 4: Kelas -->
                    <div class="tab-pane fade show {{ request('tab') === 'kelas' ? 'active' : '' }}" id="pills-kelas" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="font-weight-bold text-dark m-0"><i class="fas fa-school text-primary me-1"></i> Laporan Ruangan Kelas</h5>
                            <a href="{{ route('dashboard.kepala-sekolah.laporan.print-kelas') }}" target="_blank" class="btn btn-primary btn-cetak px-4 py-2 shadow-sm">
                                <i class="fas fa-print me-1"></i> Cetak Laporan Kelas
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Ruangan Kelas</th>
                                        <th>Wali Kelas</th>
                                        <th>Semester</th>
                                        <th>Tahun Ajaran</th>
                                        <th class="text-center">Jumlah Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classrooms as $idx => $c)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td class="font-weight-bold text-dark">{{ $c->kelas->nama }} - {{ $c->rombel->nama }}</td>
                                            <td>{{ $c->guru->nama_lengkap ?? '-' }}</td>
                                            <td>{{ $c->semester->nama }}</td>
                                            <td>{{ $c->tahun_ajaran }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-info text-white font-weight-bold px-2.5 py-1.5 rounded-pill">
                                                    {{ $c->anggotaKelas->count() }} Siswa
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 5: Mapel -->
                    <div class="tab-pane fade show {{ request('tab') === 'mapel' ? 'active' : '' }}" id="pills-mapel" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="font-weight-bold text-dark m-0"><i class="fas fa-book text-primary me-1"></i> Laporan Mata Pelajaran</h5>
                            <a href="{{ route('dashboard.kepala-sekolah.laporan.print-mapel') }}" target="_blank" class="btn btn-primary btn-cetak px-4 py-2 shadow-sm">
                                <i class="fas fa-print me-1"></i> Cetak Laporan Mapel
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $idx => $subj)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td class="font-weight-bold text-dark">{{ $subj->nama }}</td>
                                            <td class="text-secondary">{{ $subj->deskripsi ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
