<x-dashboard.layoutDashboard.app title="Hasil Nilai Belajar">
    <x-slot:myStyle>
        <style>
            .avatar-profile {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 50%;
                border: 3px solid #1572e8;
                box-shadow: 0 4px 12px rgba(21, 114, 232, 0.15);
            }
            .bio-table td {
                padding: 6px 12px;
                border: none;
            }
            .grade-badge {
                font-weight: 700;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 0.85rem;
            }
            .grade-a { background-color: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid #28a745; }
            .grade-b { background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; border: 1px solid #17a2b8; }
            .grade-c { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; }
            .grade-d { background-color: rgba(253, 126, 20, 0.1); color: #fd7e14; border: 1px solid #fd7e14; }
            .grade-e { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid #dc3545; }
            .grade-none { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; }
            
            .attendance-card {
                border-radius: 12px;
                transition: transform 0.2s ease-in-out;
            }
            .attendance-card:hover {
                transform: translateY(-2px);
            }
        </style>
    </x-slot:myStyle>

    <div class="row">
        <!-- Biodata Card -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white" style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title font-weight-bold m-0 text-white">
                            <i class="fas fa-id-card me-2"></i> Profil & Identitas Siswa
                        </h4>
                        <a href="{{ route('dashboard.siswa.nilai.index') }}" class="btn btn-light btn-sm btn-round text-primary font-weight-bold">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Riwayat
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="avatar-profile">
                            @else
                                <img src="https://www.gravatar.com/avatar/{{ md5(trim(strtolower($siswa->user->email))) }}?d=mp&s=150" alt="Preview Foto" class="avatar-profile">
                            @endif
                            <h5 class="font-weight-bold text-dark mt-3 mb-1">{{ $siswa->nama_panggilan ?? $siswa->nama_lengkap }}</h5>
                            <span class="badge bg-light text-secondary border font-mono">NIS. {{ $siswa->nis ?? '-' }}</span>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table bio-table">
                                        <tbody>
                                            <tr>
                                                <td class="text-secondary font-weight-bold" style="width: 35%;">Nama Lengkap</td>
                                                <td style="width: 5%;">:</td>
                                                <td class="text-dark font-weight-bold">{{ $siswa->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-secondary font-weight-bold">NISN</td>
                                                <td>:</td>
                                                <td class="text-dark font-mono font-weight-bold text-primary">{{ $siswa->nisn ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-secondary font-weight-bold">Email Belajar</td>
                                                <td>:</td>
                                                <td class="text-dark font-weight-bold">{{ $siswa->user->email }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table bio-table">
                                        <tbody>
                                            <tr>
                                                <td class="text-secondary font-weight-bold" style="width: 35%;">Jenis Kelamin</td>
                                                <td style="width: 5%;">:</td>
                                                <td class="text-dark">{{ $siswa->jenisKelamin->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-secondary font-weight-bold">Agama</td>
                                                <td>:</td>
                                                <td class="text-dark">{{ $siswa->agama->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-secondary font-weight-bold">Lahir</td>
                                                <td>:</td>
                                                <td class="text-dark">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Semester Tabs & Assessment Results -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        @foreach($semesterData as $index => $data)
                            <li class="nav-item">
                                <button class="nav-link @if($index === 0) active @endif font-weight-bold btn-round" 
                                        id="pills-sem-{{ $data['classroom']->id }}-tab" 
                                        data-bs-toggle="pill" 
                                        data-bs-target="#pills-sem-{{ $data['classroom']->id }}" 
                                        type="button" 
                                        role="tab" 
                                        aria-controls="pills-sem-{{ $data['classroom']->id }}" 
                                        aria-selected="@if($index === 0) true @endif">
                                    <i class="fa fa-graduation-cap me-1"></i> {{ $data['semester_name'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="pills-tabContent">
                        @foreach($semesterData as $index => $data)
                            <div class="tab-pane fade @if($index === 0) show active @endif" 
                                 id="pills-sem-{{ $data['classroom']->id }}" 
                                 role="tabpanel" 
                                 aria-labelledby="pills-sem-{{ $data['classroom']->id }}-tab">
                                
                                <div class="row">
                                    <!-- Top Section: Grades Table -->
                                    <div class="col-12 mb-4">
                                        <h5 class="text-dark font-weight-bold mb-3">
                                            <i class="fa fa-book text-primary me-2"></i> Penilaian Mata Pelajaran - {{ $data['semester_name'] }}
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover align-middle border">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 50px;" class="text-center">No</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th class="text-center" style="width: 80px;">Formatif</th>
                                                        <th class="text-center" style="width: 80px;">Sumatif LM</th>
                                                        <th class="text-center" style="width: 80px;">Sumatif Akhir</th>
                                                        <th class="text-center" style="width: 90px;">Nilai Akhir</th>
                                                        <th class="text-center" style="width: 80px;">Grade</th>
                                                        <th>Capaian Kompetensi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($data['gradesSheet'] as $gIndex => $gItem)
                                                        <tr>
                                                            <td class="text-center font-weight-bold text-secondary">{{ $gIndex + 1 }}</td>
                                                            <td>
                                                                <div class="text-dark font-weight-bold">{{ $gItem['subject']->nama }}</div>
                                                                <small class="text-muted font-mono">ID Mapel: {{ $gItem['subject']->id }}</small>
                                                            </td>
                                                            <td class="text-center font-mono font-weight-bold">{{ $gItem['nilai'] && $gItem['nilai']->nilai_formatif !== null ? number_format($gItem['nilai']->nilai_formatif, 1) : '-' }}</td>
                                                            <td class="text-center font-mono font-weight-bold">{{ $gItem['nilai'] && $gItem['nilai']->nilai_sumatif_materi !== null ? number_format($gItem['nilai']->nilai_sumatif_materi, 1) : '-' }}</td>
                                                            <td class="text-center font-mono font-weight-bold">{{ $gItem['nilai'] && $gItem['nilai']->nilai_sumatif_akhir !== null ? number_format($gItem['nilai']->nilai_sumatif_akhir, 1) : '-' }}</td>
                                                            <td class="text-center font-mono font-weight-bold text-primary">
                                                                {{ $gItem['nilai'] && $gItem['nilai']->nilai_akhir !== null ? number_format($gItem['nilai']->nilai_akhir, 1) : '-' }}
                                                            </td>
                                                            <td class="text-center">
                                                                @php
                                                                    $gradeLetter = $gItem['grade'];
                                                                    $gradeClass = 'grade-none';
                                                                    if($gradeLetter === 'A') $gradeClass = 'grade-a';
                                                                    elseif($gradeLetter === 'B') $gradeClass = 'grade-b';
                                                                    elseif($gradeLetter === 'C') $gradeClass = 'grade-c';
                                                                    elseif($gradeLetter === 'D') $gradeClass = 'grade-d';
                                                                    elseif($gradeLetter === 'E') $gradeClass = 'grade-e';
                                                                @endphp
                                                                <span class="grade-badge {{ $gradeClass }}">{{ $gradeLetter }}</span>
                                                            </td>
                                                            <td class="fs-7 text-secondary" style="white-space: pre-wrap; max-width: 250px;">{{ $gItem['nilai']?->keterangan ?? 'Belum ada deskripsi pencapaian kompetensi.' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="8" class="text-center py-4 text-muted">
                                                                Belum ada mata pelajaran terjadwal pada semester ini.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Middle Section: Attendance Summary -->
                                    <div class="col-12 mb-4">
                                        <h5 class="text-dark font-weight-bold mb-3">
                                            <i class="fa fa-calendar-check text-primary me-2"></i> Rekap Absensi Semester
                                        </h5>

                                        <!-- Attendance Statistics Cards -->
                                        <div class="row g-3">
                                            <div class="col-6 col-md-3">
                                                <div class="card attendance-card bg-success text-white border-0 shadow-sm m-0">
                                                    <div class="card-body p-3 text-center">
                                                        <h4 class="font-weight-bold m-0 text-white">{{ $data['absensiSummary']['Hadir'] }}</h4>
                                                        <small class="text-white-50">Hadir</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="card attendance-card bg-info text-white border-0 shadow-sm m-0">
                                                    <div class="card-body p-3 text-center">
                                                        <h4 class="font-weight-bold m-0 text-white">{{ $data['absensiSummary']['Sakit'] }}</h4>
                                                        <small class="text-white-50">Sakit</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="card attendance-card bg-warning text-dark border-0 shadow-sm m-0">
                                                    <div class="card-body p-3 text-center">
                                                        <h4 class="font-weight-bold m-0 text-dark">{{ $data['absensiSummary']['Izin'] }}</h4>
                                                        <small class="text-dark-50">Izin</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="card attendance-card bg-danger text-white border-0 shadow-sm m-0">
                                                    <div class="card-body p-3 text-center">
                                                        <h4 class="font-weight-bold m-0 text-white">{{ $data['absensiSummary']['Alpa'] }}</h4>
                                                        <small class="text-white-50">Alpa (Absen)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bottom Section: Attendance History / Absence log -->
                                    <div class="col-12">
                                        <div class="card border border-light bg-light rounded-3 m-0">
                                            <div class="card-header bg-white border-bottom-0 py-3">
                                                <h6 class="font-weight-bold text-dark m-0">
                                                    <i class="fa fa-history text-secondary me-2"></i> Log Ketidakhadiran
                                                </h6>
                                            </div>
                                            <div class="card-body p-3 pt-0">
                                                @if($data['attendanceHistory']->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-borderless m-0 align-middle">
                                                            <thead>
                                                                <tr class="border-bottom">
                                                                    <th>Tanggal</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th>Keterangan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($data['attendanceHistory'] as $att)
                                                                    <tr class="border-bottom-0">
                                                                        <td class="font-mono text-dark fs-7">{{ \Carbon\Carbon::parse($att->tanggal)->format('d-m-Y') }}</td>
                                                                        <td class="text-center">
                                                                            @if($att->status === 'Sakit')
                                                                                <span class="badge bg-info text-white fs-8">Sakit</span>
                                                                            @elseif($att->status === 'Izin')
                                                                                <span class="badge bg-warning text-dark fs-8">Izin</span>
                                                                            @else
                                                                                <span class="badge bg-danger text-white fs-8">Alpa</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-secondary fs-7" style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $att->keterangan ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="text-center py-4 text-success font-weight-bold fs-7">
                                                        <i class="fa fa-check-circle me-1"></i> Kehadiran Sempurna!
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
