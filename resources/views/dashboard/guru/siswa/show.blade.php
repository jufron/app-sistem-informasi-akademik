<x-dashboard.layoutDashboard.app title="Profil Detail Siswa">
    <x-slot:myStyle>
        <style>
            .profile-header-card {
                background: linear-gradient(135deg, #1d8cf8 0%, #1171ef 100%);
                color: #ffffff;
                border-radius: 16px;
                border: none;
                position: relative;
                overflow: hidden;
            }
            .profile-avatar-container {
                width: 140px;
                height: 140px;
                border-radius: 50%;
                border: 4px solid rgba(255,255,255,0.25);
                overflow: hidden;
                background-color: #f8f9fa;
                margin: 0 auto;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
            .profile-avatar {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .detail-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }
            .detail-label {
                font-weight: 700;
                color: #495057;
                width: 35%;
            }
            .detail-value {
                color: #212529;
            }
        </style>
    </x-slot:myStyle>

    <div class="row">
        <!-- Profile Header/Photo Card -->
        <div class="col-md-4 text-center">
            <div class="card profile-header-card p-4 mb-4 shadow-sm">
                <div class="profile-avatar-container mb-3">
                    @php
                        $avatarUrl = $siswa->foto 
                            ? asset('storage/' . $siswa->foto) 
                            : ($siswa->jenisKelamin && $siswa->jenisKelamin->nama === 'Perempuan' 
                                ? 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=200&auto=format&fit=crop' 
                                : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop');
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="Foto {{ $siswa->nama_lengkap }}" class="profile-avatar">
                </div>
                <h4 class="font-weight-bold mb-1">{{ $siswa->nama_lengkap }}</h4>
                <p class="mb-2 opacity-80" style="font-size: 0.9rem;">NISN: {{ $siswa->nisn ?? '-' }}</p>
                <div class="mt-2">
                    <span class="badge {{ $siswa->status === 'Aktif' ? 'bg-success' : 'bg-danger' }} text-white px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                        <i class="fas {{ $siswa->status === 'Aktif' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                        Status: {{ $siswa->status ?? 'Aktif' }}
                    </span>
                </div>
            </div>

            <!-- Back Button -->
            <button onclick="window.history.back()" class="btn btn-secondary btn-round w-100 py-2.5 shadow-sm mb-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Sebelumnya
            </button>
        </div>

        <!-- Student Profile Details Table -->
        <div class="col-md-8">
            <div class="card detail-card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="font-weight-bold text-dark m-0">
                        <i class="fas fa-user text-primary me-2"></i> Biodata Lengkap Siswa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <tbody>
                                <tr>
                                    <td class="detail-label">Nama Lengkap</td>
                                    <td style="width: 5%">:</td>
                                    <td class="detail-value font-weight-bold text-dark">{{ $siswa->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">Nama Panggilan</td>
                                    <td>:</td>
                                    <td class="detail-value">{{ $siswa->nama_panggilan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">NISN</td>
                                    <td>:</td>
                                    <td class="detail-value font-mono font-weight-bold">{{ $siswa->nisn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">NIS</td>
                                    <td>:</td>
                                    <td class="detail-value font-mono">{{ $siswa->nis ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">Jenis Kelamin</td>
                                    <td>:</td>
                                    <td class="detail-value">{{ $siswa->jenisKelamin->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">Agama</td>
                                    <td>:</td>
                                    <td class="detail-value">{{ $siswa->agama->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="detail-label">Tempat, Tanggal Lahir</td>
                                    <td>:</td>
                                    <td class="detail-value">
                                        {{ $siswa->tempat_lahir ?? '-' }}, 
                                        {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="detail-label">No. Telepon / HP</td>
                                    <td>:</td>
                                    <td class="detail-value">
                                        @if($siswa->telepon)
                                            <a href="tel:{{ $siswa->telepon }}"><i class="fas fa-phone-alt me-1"></i> {{ $siswa->telepon }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="detail-label">Alamat Lengkap</td>
                                    <td>:</td>
                                    <td class="detail-value" style="white-space: pre-line;">{{ $siswa->alamat ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layoutDashboard.app>
