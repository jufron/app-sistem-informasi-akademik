<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Siswa</title>
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
        $namaSekolah = get_app_setting('nama_sekolah', 'NAMA SEKOLAH');
        $alamatSekolah = get_app_setting('alamat_sekolah', 'Alamat Sekolah Belum Diatur');
        $teleponSekolah = get_app_setting('nomor_telepon_kantor', '');
        $emailSekolah = get_app_setting('email', '');
        $logoSekolah = get_app_setting('logo_sekolah', '');
        $namaKepsek = get_app_setting('nama_kepala_sekolah', 'Kepala Sekolah, S.Pd.');
    @endphp

    <div class="container-fluid">
        <!-- Buttons for Action -->
        <div class="row mb-3 no-print">
            <div class="col-md-12 text-end">
                <button onclick="window.print()" class="btn btn-primary me-2"><i class="fas fa-print"></i> Cetak</button>
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
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h5 class="fw-bold decoration-underline">LAPORAN DATA INDUK SISWA</h5>
            </div>
        </div>

        <!-- Table Data -->
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-laporan align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 120px;">NIS</th>
                            <th style="width: 150px;">NISN</th>
                            <th>Nama Lengkap</th>
                            <th style="width: 100px;">JK</th>
                            <th style="width: 120px;">Agama</th>
                            <th style="width: 120px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $idx => $s)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td class="text-center font-mono">{{ $s->nis ?? '-' }}</td>
                                <td class="text-center font-mono text-muted">{{ $s->nisn ?? '-' }}</td>
                                <td class="fw-bold">{{ $s->nama_lengkap }}</td>
                                <td class="text-center">{{ $s->jenisKelamin->kode ?? '-' }}</td>
                                <td class="text-center">{{ $s->agama->nama ?? '-' }}</td>
                                <td class="text-center">{{ $s->status }}</td>
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
