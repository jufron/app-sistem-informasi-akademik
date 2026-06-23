<x-dashboard.layoutDashboard.app title="Input Nilai Kurikulum Merdeka">
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
                padding: 12px 0;
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
                background-color: rgba(21, 114, 232, 0.03) !important;
            }
            .input-grade {
                width: 80px;
                text-align: center;
                border-radius: 8px;
                border: 1px solid #ced4da;
                padding: 6px;
                font-weight: 600;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }
            .input-grade:focus {
                border-color: #1572e8;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
            }
            .input-desc {
                min-width: 200px;
                border-radius: 8px;
                border: 1px solid #ced4da;
                padding: 6px 12px;
                transition: border-color 0.2s ease;
            }
            .input-desc:focus {
                border-color: #1572e8;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
            }
            .btn-save-grades {
                background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
                border: none;
                color: white !important;
                font-weight: 600;
                border-radius: 30px !important;
                padding: 10px 24px;
                transition: all 0.25s ease;
            }
            .btn-save-grades:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(40, 167, 69, 0.35) !important;
            }
            .btn-back {
                border-radius: 30px !important;
                font-weight: 600;
                transition: all 0.2s;
            }
            .btn-back:hover {
                transform: translateX(-3px);
            }
            .nilai-akhir-badge {
                font-size: 0.95rem;
                font-weight: 700;
                padding: 6px 12px;
                border-radius: 8px;
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
                            <i class="fas fa-edit me-1"></i> Penilaian Kurikulum Merdeka
                        </span>
                        <h2 class="font-weight-bold mb-1">
                            {{ $ruanganKelas->kelas->nama ?? '-' }} - {{ $ruanganKelas->rombel->nama ?? '-' }}
                        </h2>
                        <p class="mb-0 opacity-90" style="font-size: 0.95rem;">
                            Tahun Ajaran {{ $ruanganKelas->tahun_ajaran ?? '-' }} • Semester {{ $ruanganKelas->semester->nama ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('dashboard.guru.penilaian.index') }}" class="btn btn-light btn-round px-4 py-2 text-primary font-weight-bold shadow-sm" style="transition: all 0.2s;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info and Selector Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card info-card shadow-sm border-0">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <form action="{{ route('dashboard.guru.penilaian.show', $ruanganKelas->id) }}" method="GET" id="form-subject-select">
                                <div class="form-group p-0 m-0">
                                    <label for="mata_pelajaran_id" class="form-label font-weight-bold text-dark mb-2">
                                        <i class="fas fa-book text-primary me-1"></i> Pilih Mata Pelajaran
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
                            </form>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-4 justify-content-md-end mt-3 mt-md-0">
                                <div>
                                    <span class="text-secondary d-block font-weight-bold mb-1" style="font-size: 0.8rem;"><i class="fas fa-school me-1 text-muted"></i> Kelas</span>
                                    <span class="text-dark font-weight-bold" style="font-size: 0.95rem;">{{ $ruanganKelas->kelas->nama ?? '-' }} - {{ $ruanganKelas->rombel->nama ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-secondary d-block font-weight-bold mb-1" style="font-size: 0.8rem;"><i class="fas fa-chalkboard-teacher me-1 text-muted"></i> Wali Kelas</span>
                                    <span class="text-dark font-weight-bold" style="font-size: 0.95rem;">{{ $ruanganKelas->guru->nama_lengkap ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-secondary d-block font-weight-bold mb-1" style="font-size: 0.8rem;"><i class="fas fa-book-open me-1 text-muted"></i> Semester</span>
                                    <span class="text-dark font-weight-bold" style="font-size: 0.95rem;">{{ $ruanganKelas->semester->nama ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-secondary d-block font-weight-bold mb-1" style="font-size: 0.8rem;"><i class="fas fa-history me-1 text-muted"></i> Tahun Ajaran</span>
                                    <span class="text-dark font-weight-bold" style="font-size: 0.95rem;">{{ $ruanganKelas->tahun_ajaran ?? '-' }}</span>
                                </div>
                                @if($selectedSubjectId !== null)
                                    <div>
                                        <span class="text-secondary d-block font-weight-bold mb-1" style="font-size: 0.8rem;"><i class="fas fa-users me-1 text-muted"></i> Total Siswa</span>
                                        <span class="badge bg-primary text-white font-weight-bold px-3 py-1.5 rounded-pill">{{ count($gradesSheet) }} Siswa</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Input Board -->
    <div class="row">
        <div class="col-md-12">
            <div class="card student-card shadow-sm border-0">
                @if($selectedSubjectId === null)
                    <div class="card-body text-center py-5 text-muted">
                        <i class="fas fa-book-open fa-4x mb-3 text-secondary opacity-60"></i>
                        <h4 class="font-weight-bold text-dark">Mata Pelajaran Belum Dipilih</h4>
                        <p class="mb-0">Silakan pilih salah satu mata pelajaran yang Anda ajarkan di kelas ini pada panel di atas untuk menampilkan lembar penilaian.</p>
                    </div>
                @else
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="font-weight-bold text-dark m-0">
                            <i class="fas fa-users-cog text-success me-2"></i> Lembar Penilaian Siswa
                        </h5>
                        <span class="badge bg-success-transparent text-success px-3 py-1.5 rounded-pill font-weight-bold" style="background-color: rgba(40,167,69,0.1);">
                            <i class="fas fa-check-circle me-1"></i> Mode Input Aktif
                        </span>
                    </div>
                    
                    <div class="card-body">
                        <!-- Validation Alerts -->
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

                        <!-- Pending Revision Alerts -->
                        @if (isset($pendingRevisions) && $pendingRevisions->isNotEmpty())
                            @foreach ($pendingRevisions as $revisi)
                                <div class="alert alert-warning border-0 shadow-sm p-4 mb-4" style="border-radius: 12px; background-color: rgba(255, 193, 7, 0.15);">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div class="d-flex">
                                            <i class="fas fa-exclamation-circle text-warning fa-2x me-3 mt-1"></i>
                                            <div>
                                                <h6 class="font-weight-bold text-dark mb-1">Permintaan Revisi Nilai dari Kepala Sekolah:</h6>
                                                <p class="mb-0 text-secondary" style="font-size: 0.9rem;">"{{ $revisi->pesan }}"</p>
                                                <small class="text-muted d-block mt-1">Dikirim pada: {{ $revisi->created_at }}</small>
                                            </div>
                                        </div>
                                        <div>
                                            <form action="{{ route('dashboard.guru.penilaian.revisi.resolve', $revisi->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning btn-round font-weight-bold px-3 py-1.5 shadow-sm" style="border-radius: 20px;">
                                                    <i class="fas fa-check me-1"></i> Tandai Selesai Revisi
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <form action="{{ route('dashboard.guru.penilaian.store', $ruanganKelas->id) }}" method="POST" id="form-grades">
                            @csrf
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $selectedSubjectId }}">

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Siswa</th>
                                            <th class="text-center">Formatif (F)<br><small class="text-muted">Proses</small></th>
                                            <th class="text-center">Sumatif LM<br><small class="text-muted">Materi</small></th>
                                            <th class="text-center">Sumatif Akhir (SAS)<br><small class="text-muted">Akhir Sem.</small></th>
                                            <th class="text-center">Nilai Akhir (NA)<br><small class="text-muted">K. Merdeka</small></th>
                                            <th>Deskripsi Capaian Kompetensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($gradesSheet as $index => $item)
                                            @php
                                                $nilai = $item['nilai'];
                                                $siswa = $item['siswa'];
                                            @endphp
                                            <tr class="student-row" data-student-id="{{ $siswa->id }}">
                                                <td class="text-secondary font-weight-bold">
                                                    {{ $index + 1 }}
                                                    <input type="hidden" name="grades[{{ $index }}][siswa_id]" value="{{ $siswa->id }}">
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                                                    <small class="text-muted font-mono">NIS: {{ $siswa->nis ?? '-' }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" 
                                                           step="0.01"
                                                           min="0" 
                                                           max="100" 
                                                           name="grades[{{ $index }}][nilai_formatif]" 
                                                           value="{{ old("grades.{$index}.nilai_formatif", $nilai->nilai_formatif ?? '') }}" 
                                                           class="form-control input-grade input-formatif">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" 
                                                           step="0.01"
                                                           min="0" 
                                                           max="100" 
                                                           name="grades[{{ $index }}][nilai_sumatif_materi]" 
                                                           value="{{ old("grades.{$index}.nilai_sumatif_materi", $nilai->nilai_sumatif_materi ?? '') }}" 
                                                           class="form-control input-grade input-sumatif-materi">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" 
                                                           step="0.01"
                                                           min="0" 
                                                           max="100" 
                                                           name="grades[{{ $index }}][nilai_sumatif_akhir]" 
                                                           value="{{ old("grades.{$index}.nilai_sumatif_akhir", $nilai->nilai_sumatif_akhir ?? '') }}" 
                                                           class="form-control input-grade input-sumatif-akhir">
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border display-nilai-akhir nilai-akhir-badge">
                                                        {{ $nilai && $nilai->nilai_akhir !== null ? number_format($nilai->nilai_akhir, 2) : '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           name="grades[{{ $index }}][keterangan]" 
                                                           value="{{ old("grades.{$index}.keterangan", $nilai->keterangan ?? '') }}" 
                                                           placeholder="e.g. Menunjukkan penguasaan materi sangat baik..." 
                                                           class="form-control input-desc">
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5 text-muted">
                                                    <i class="fas fa-users-slash fa-3x mb-2 d-block"></i> Tidak ada siswa yang aktif di kelas ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if(count($gradesSheet) > 0)
                                <div class="d-flex justify-content-end mt-4 border-top pt-3">
                                    <button type="submit" class="btn btn-success btn-save-grades btn-round shadow-sm">
                                        <i class="fas fa-save me-2"></i> Simpan Semua Nilai
                                    </button>
                                </div>
                            @endif
                        </form>

                        <!-- Riwayat Catatan Revisi dari Kepala Sekolah -->
                        @if (isset($allRevisions) && $allRevisions->isNotEmpty())
                            <div class="border-top pt-4 mt-4">
                                <div class="card border shadow-sm p-4 mb-0" style="border-radius: 12px; max-height: 350px; overflow-y: auto; background-color: #fafbfc;">
                                    <h6 class="font-weight-bold text-dark mb-3">
                                        <i class="fas fa-history text-secondary me-2"></i> Riwayat Catatan Revisi Kepala Sekolah
                                    </h6>
                                    <div class="row">
                                        @foreach($allRevisions as $rev)
                                            <div class="col-md-12 border-bottom py-3 {{ $loop->last ? 'border-0' : '' }}">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="badge {{ $rev->status === 'Pending' ? 'bg-warning text-white' : 'bg-success text-white' }} px-2 py-1" style="font-size: 0.75rem;">
                                                        {{ $rev->status }}
                                                    </span>
                                                    <small class="text-muted font-mono" style="font-size: 0.8rem;">{{ $rev->created_at }}</small>
                                                </div>
                                                <p class="mb-0 text-secondary" style="font-size: 0.9rem;">"{{ $rev->pesan }}"</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-slot:myScript>
        @if($selectedSubjectId !== null)
            <script>
                jQuery(function($) {
                    // Function to calculate final score dynamically
                    function calculateRowFinalScore(row) {
                        var inputMateri = $(row).find('.input-sumatif-materi').val();
                        var inputAkhir = $(row).find('.input-sumatif-akhir').val();
                        
                        var scoreMateri = parseFloat(inputMateri);
                        var scoreAkhir = parseFloat(inputAkhir);
                        
                        var hasMateri = !isNaN(scoreMateri) && inputMateri !== '';
                        var hasAkhir = !isNaN(scoreAkhir) && inputAkhir !== '';
                        
                        var finalScoreElement = $(row).find('.display-nilai-akhir');
                        
                        if (hasMateri && hasAkhir) {
                            var na = (scoreMateri + scoreAkhir) / 2;
                            finalScoreElement.text(na.toFixed(2)).removeClass('bg-light text-dark').addClass('bg-primary text-white');
                        } else if (hasMateri) {
                            finalScoreElement.text(scoreMateri.toFixed(2)).removeClass('bg-light text-dark').addClass('bg-primary text-white');
                        } else if (hasAkhir) {
                            finalScoreElement.text(scoreAkhir.toFixed(2)).removeClass('bg-light text-dark').addClass('bg-primary text-white');
                        } else {
                            finalScoreElement.text('-').removeClass('bg-primary text-white').addClass('bg-light text-dark');
                        }
                    }

                    // Perform calculation on loading to style the badges properly
                    $('.student-row').each(function() {
                        calculateRowFinalScore(this);
                    });

                    // Trigger calculation on input change
                    $(document).on('input', '.input-sumatif-materi, .input-sumatif-akhir', function() {
                        var row = $(this).closest('.student-row');
                        calculateRowFinalScore(row);
                    });
                });
            </script>
        @endif
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
