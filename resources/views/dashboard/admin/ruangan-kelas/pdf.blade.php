<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rombongan Belajar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #2D3748;
            margin: 0;
            padding: 30px;
            background-color: #ffffff;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Decorative Header */
        .pdf-header {
            border-bottom: 2px solid #1572e8;
            padding-bottom: 15px;
            margin-bottom: 25px;
            position: relative;
        }
        
        .header-title-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            font-size: 12px;
            color: #718096;
            margin: 2px 0 0 0;
        }

        .header-meta {
            text-align: right;
            font-size: 11px;
            color: #718096;
        }

        /* Metadata Cards Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: #f7fafc;
            border: 1px solid #edf2f7;
            border-radius: 8px;
            padding: 15px;
        }

        .card-title {
            font-size: 11px;
            font-weight: 700;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: 600;
            color: #718096;
            width: 130px;
        }

        .info-value {
            color: #2d3748;
            font-weight: 500;
        }

        /* Section Heading */
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a202c;
            margin: 0 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
        }

        /* Students Table */
        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .student-table th {
            background-color: #edf2f7;
            color: #4a5568;
            font-weight: 700;
            text-align: left;
            padding: 10px 12px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #cbd5e0;
        }

        .student-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .student-table tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .student-name {
            font-weight: 600;
            color: #2d3748;
        }

        .student-sub {
            font-size: 11px;
            color: #718096;
            margin-top: 2px;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: 700;
            border-radius: 12px;
            text-align: center;
        }

        .badge-success { background-color: #c6f6d5; color: #22543d; }
        .badge-info { background-color: #ebf8ff; color: #2b6cb0; }
        .badge-warning { background-color: #feebc8; color: #744210; }
        .badge-danger { background-color: #fed7d7; color: #742a2a; }
        .badge-primary { background-color: #ebf4ff; color: #2b6cb0; }
        .badge-secondary { background-color: #edf2f7; color: #4a5568; }

        .date-text {
            color: #4a5568;
            font-size: 12px;
        }

        .keterangan-text {
            font-style: italic;
            color: #718096;
            font-size: 12px;
        }

        /* Footer */
        .pdf-footer {
            margin-top: 40px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #a0aec0;
        }
    </style>
</head>
<body>

    <!-- Header Block -->
    <div class="pdf-header">
        <div class="header-title-container">
            <div>
                <h1 class="header-title">LAPORAN ANGGOTA ROMBONGAN BELAJAR</h1>
                <p class="header-subtitle">Sistem Informasi Akademik Sekolah</p>
            </div>
            <div class="header-meta">
                <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}<br>
                <strong>Waktu Cetak:</strong> {{ \Carbon\Carbon::now()->format('H:i') }} WIB
            </div>
        </div>
    </div>

    <!-- Section 1: Detailed Info (Grid Layout) -->
    <div class="section-title">
        I. IDENTITAS RUANGAN KELAS
    </div>
    
    <div class="info-grid">
        <div class="info-card">
            <h3 class="card-title">Atribut Kelas</h3>
            <table class="info-table">
                <tr>
                    <td class="info-label">Kelas</td>
                    <td>:</td>
                    <td class="info-value">{{ $ruanganKelas->kelas ? $ruanganKelas->kelas->nama : '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Rombongan Belajar</td>
                    <td>:</td>
                    <td class="info-value">{{ $ruanganKelas->rombel ? $ruanganKelas->rombel->nama : '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Semester</td>
                    <td>:</td>
                    <td class="info-value">{{ $ruanganKelas->semester ? $ruanganKelas->semester->nama : '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Status Keaktifan</td>
                    <td>:</td>
                    <td class="info-value">
                        @if($ruanganKelas->aktif)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="info-card">
            <h3 class="card-title">Manajemen & Angkatan</h3>
            <table class="info-table">
                <tr>
                    <td class="info-label">Wali Kelas</td>
                    <td>:</td>
                    <td class="info-value">{{ $ruanganKelas->guru ? $ruanganKelas->guru->nama_lengkap : '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tahun Angkatan</td>
                    <td>:</td>
                    <td class="info-value">{{ $ruanganKelas->tahun_angkatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tahun Ajaran</td>
                    <td>:</td>
                    <td class="info-value">{{ $ruanganKelas->tahun_ajaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Total Anggota Siswa</td>
                    <td>:</td>
                    <td class="info-value"><strong>{{ count($ruanganKelas->anggotaKelas) }} Siswa</strong></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Section 2: Enrolled Students Table -->
    <div class="section-title" style="margin-top: 10px;">
        II. DAFTAR ANGGOTA ROMBONGAN BELAJAR (SISWA)
    </div>

    <table class="student-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 35%;">Data Lengkap Siswa</th>
                <th style="width: 15%;">Tanggal Masuk</th>
                <th style="width: 15%;">Tanggal Keluar</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 15%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruanganKelas->anggotaKelas as $index => $member)
                <tr>
                    <td style="text-align: center; font-weight: bold; color: #718096;">{{ $index + 1 }}</td>
                    <td>
                        <div class="student-name">{{ $member->siswa ? $member->siswa->nama_lengkap : '-' }}</div>
                        <div class="student-sub">
                            NISN: {{ $member->siswa ? $member->siswa->nisn : '-' }} | NIS: {{ $member->siswa ? $member->siswa->nis : '-' }}
                        </div>
                    </td>
                    <td class="date-text">
                        {{ $member->tanggal_masuk ? \Carbon\Carbon::parse($member->tanggal_masuk)->isoFormat('D MMM YYYY') : '-' }}
                    </td>
                    <td class="date-text">
                        {{ $member->tanggal_keluar ? \Carbon\Carbon::parse($member->tanggal_keluar)->isoFormat('D MMM YYYY') : '-' }}
                    </td>
                    <td>
                        @php
                            $status = $member->status ?? 'Aktif';
                            $badgeClass = 'badge-secondary';
                            if ($status === 'Aktif') $badgeClass = 'badge-success';
                            elseif ($status === 'Naik Kelas' || $status === 'Lulus') $badgeClass = 'badge-info';
                            elseif ($status === 'Tinggal Kelas') $badgeClass = 'badge-warning';
                            elseif ($status === 'Mutasi Keluar' || $status === 'Keluar') $badgeClass = 'badge-danger';
                            elseif ($status === 'Mutasi Masuk') $badgeClass = 'badge-primary';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    </td>
                    <td class="keterangan-text">
                        {{ $member->keterangan ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #a0aec0; font-style: italic;">
                        Tidak ada data siswa terdaftar di ruangan kelas ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PDF Footer -->
    <div class="pdf-footer">
        <div>
            Dicetak secara sistematis melalui Sistem Informasi Akademik
        </div>
        <div>
            Halaman 1 dari 1
        </div>
    </div>

</body>
</html>
