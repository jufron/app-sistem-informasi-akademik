<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Akademik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
            color: #000000;
            padding: 20px;
        }
        .kop-surat {
            border-bottom: 3px double #000000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-sekolah {
            max-height: 85px;
            object-fit: contain;
        }
        .meta-info {
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        .table-laporan th {
            background-color: #f2f2f2 !important;
            color: #000000 !important;
            border: 1px solid #000000 !important;
            font-weight: bold;
            text-align: center;
        }
        .table-laporan td {
            border: 1px solid #000000 !important;
        }
        .ttd-section {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    @php
        $namaSekolah = \App\Models\AppSetting::where('key', 'nama_sekolah')->first()?->value ?? 'NAMA SEKOLAH';
        $alamatSekolah = \App\Models\AppSetting::where('key', 'alamat_sekolah')->first()?->value ?? 'Alamat Sekolah Belum Diatur';
        $teleponSekolah = \App\Models\AppSetting::where('key', 'nomor_telepon_kantor')->first()?->value ?? '';
        $emailSekolah = \App\Models\AppSetting::where('key', 'email')->first()?->value ?? '';
        $logoSekolah = \App\Models\AppSetting::where('key', 'logo_sekolah')->first()?->value ?? '';
        $namaKepsek = \App\Models\AppSetting::where('key', 'nama_kepala_sekolah')->first()?->value ?? 'Kepala Sekolah, S.Pd.';
    @endphp

    <div class="container-fluid">
        <!-- Action Buttons -->
        <div class="row mb-3 no-print">
            <div class="col-md-12 text-end">
                <button onclick="window.print()" class="btn btn-primary me-2">Cetak</button>
                <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
            </div>
        </div>

        <!-- Kop Surat -->
        <div class="row kop-surat align-items-center">
            <div class="col-2 text-center">
                @if($logoSekolah)
                    <img src="{{ asset('storage/' . $logoSekolah) }}" class="logo-sekolah" alt="Logo">
                @else
                    <div style="width: 80px; height: 80px; border: 1px dashed #000; line-height: 80px; font-size: 10px;">LOGO</div>
                @endif
            </div>
            <div class="col-10 text-center">
                <h3 class="fw-bold m-0" style="letter-spacing: 1px;">{{ strtoupper($namaSekolah) }}</h3>
                <p class="m-0" style="font-size: 0.95rem;">{{ $alamatSekolah }}</p>
                <p class="m-0" style="font-size: 0.9rem;">
                    @if($teleponSekolah) Telp: {{ $teleponSekolah }} @endif
                    @if($emailSekolah) | Email: {{ $emailSekolah }} @endif
                </p>
            </div>
        </div>

        <!-- Title -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h5 class="fw-bold text-decoration-underline">DAFTAR NILAI AKADEMIK SISWA (KURIKULUM MERDEKA)</h5>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="row meta-info">
            <div class="col-6">
                <table class="table table-borderless table-sm m-0">
                    <tr>
                        <td style="width: 150px;" class="fw-bold">Kelas / Rombel</td>
                        <td>: {{ $classroom->kelas->nama }} - {{ $classroom->rombel->nama }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Mata Pelajaran</td>
                        <td>: {{ $subject->nama }} ({{ $subject->kode }})</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Guru Pengampu</td>
                        <td>: {{ $classroom->guru->nama_lengkap ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table table-borderless table-sm m-0 float-end" style="width: auto;">
                    <tr>
                        <td style="width: 120px;" class="fw-bold">Semester</td>
                        <td>: {{ $classroom->semester->nama }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tahun Ajaran</td>
                        <td>: {{ $classroom->tahun_ajaran }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Table Data -->
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-laporan align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th style="width: 120px;" class="text-center">Formatif (F)</th>
                            <th style="width: 120px;" class="text-center">Sumatif LM</th>
                            <th style="width: 120px;" class="text-center">Sumatif Akhir (SAS)</th>
                            <th style="width: 120px;" class="text-center">Nilai Akhir (NA)</th>
                            <th>Deskripsi Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gradesSheet as $idx => $g)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $g['siswa']->nama_lengkap }}</div>
                                    <small class="text-muted font-mono">NIS: {{ $g['siswa']->nis ?? '-' }}</small>
                                </td>
                                <td class="text-center">{{ $g['nilai']->nilai_formatif ?? '-' }}</td>
                                <td class="text-center">{{ $g['nilai']->nilai_sumatif_materi ?? '-' }}</td>
                                <td class="text-center">{{ $g['nilai']->nilai_sumatif_akhir ?? '-' }}</td>
                                <td class="text-center fw-bold">
                                    {{ $g['nilai'] && $g['nilai']->nilai_akhir !== null ? number_format($g['nilai']->nilai_akhir, 2) : '-' }}
                                </td>
                                <td>{{ $g['nilai']->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signature -->
        <div class="row">
            <div class="col-12">
                <div class="ttd-section">
                    <p class="mb-1">Sumba Barat Daya, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="mb-5">Mengetahui,<br>Kepala Sekolah</p>
                    <p class="fw-bold text-decoration-underline mb-0">{{ $namaKepsek }}</p>
                    <p class="text-muted" style="font-size: 0.85rem;">NIP. ....................................</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
