<x-dashboard.layoutDashboard.app title="Profil Saya">
    <x-slot:myStyle>
        <style>
            .profile-cover {
                height: 180px;
                background-image: linear-gradient(135deg, rgba(21, 114, 232, 0.3) 0%, rgba(0, 198, 255, 0.4) 100%), url('{{ asset('img/profile_cover_banner.png') }}');
                background-size: cover;
                background-position: center;
                border-radius: 16px;
                position: relative;
            }

            .profile-avatar-container {
                position: absolute;
                bottom: -60px;
                left: 40px;
                z-index: 2;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                border: 5px solid #ffffff;
                border-radius: 50%;
                background-color: #ffffff;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                object-fit: cover;
            }

            .profile-header-content {
                padding-top: 70px;
                padding-left: 40px;
                padding-bottom: 20px;
            }

            .profile-card {
                border-radius: 16px;
                overflow: hidden;
            }

            .info-card {
                border-radius: 12px;
            }

            .input-icon-group {
                position: relative;
            }

            .input-icon-group i {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #a0aec0;
            }

            .input-icon-group .form-control {
                padding-left: 45px;
            }

            .btn-show-password {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                border: none;
                background: none;
                color: #a0aec0;
                cursor: pointer;
                z-index: 10;
            }

            .btn-show-password:hover {
                color: #1572e8;
            }
        </style>
        {{-- ? toastify css  --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    </x-slot:myStyle>

    <div class="row">
        <div class="col-md-12 mb-4">
            <!-- Header Card with Cover and Avatar -->
            <div class="card profile-card border-0 shadow-sm">
                <div class="profile-cover"></div>
                <div class="profile-avatar-container">
                    <img src="{{ asset('img/logo.png') }}" class="profile-avatar" alt="Avatar">
                </div>
                <div class="profile-header-content bg-white">
                    <div class="d-flex flex-wrap justify-content-between align-items-center pe-4">
                        <div>
                            <h3 class="font-weight-bold text-dark mb-1">{{ $user->name }}</h3>
                            <p class="text-secondary mb-0"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            @foreach ($user->roles as $role)
                                <span class="badge bg-primary px-3 py-2 rounded-pill font-weight-bold"
                                    style="font-size: 0.8rem; text-transform: uppercase;">
                                    <i class="fas fa-user-shield me-1"></i> {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Side: Profile Summary -->
        <div class="col-lg-4 col-md-12">
            <div class="card info-card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-info-circle text-primary me-2"></i> Ringkasan Akun
                    </h5>
                </div>
                <div class="card-body py-0">
                    <table class="table table-borderless align-middle m-0" style="font-size: 0.9rem;">
                        <tbody>
                            <tr>
                                <td class="text-secondary ps-0" style="width: 40%;">Username</td>
                                <td class="text-dark font-weight-bold text-end pe-0">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary ps-0">Alamat Email</td>
                                <td class="text-dark text-end pe-0" style="word-break: break-all;">{{ $user->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-secondary ps-0">Tanggal Daftar</td>
                                <td class="text-dark text-end pe-0">
                                    {{ $user->created_at ? $user->created_at->isoFormat('D MMMM YYYY') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-secondary ps-0">Verifikasi</td>
                                <td class="text-end pe-0">
                                    @if ($user->email_verified_at)
                                        <span
                                            class="badge bg-success-light text-success font-weight-bold rounded-pill px-2.5 py-1"
                                            style="background-color: rgba(40, 167, 69, 0.1); font-size: 0.75rem;">
                                            <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-warning-light text-warning font-weight-bold rounded-pill px-2.5 py-1"
                                            style="background-color: rgba(255, 193, 7, 0.1); font-size: 0.75rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i> Belum
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <p class="text-muted m-0 text-center" style="font-size: 0.8rem;">
                        <i class="fas fa-lock me-1"></i> Akun Anda dilindungi dengan enkripsi keamanan standar tinggi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: Edit Profile and Change Password -->
        <div class="col-lg-8 col-md-12">
            <!-- Card 1: Update Profile Info -->
            <div class="card info-card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-primary font-weight-bold m-0">
                        <i class="fas fa-user-edit me-2"></i> Perbarui Informasi Profil
                    </h5>
                </div>
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="card-body">
                        <p class="text-secondary mb-4" style="font-size: 0.85rem;">
                            Perbarui nama tampilan dan alamat surel akun Anda secara mudah. Pastikan surel Anda aktif
                            untuk menerima pemberitahuan sistem.
                        </p>

                        <!-- Nama / Username -->
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold" for="name">Nama Pengguna / Tampilan</label>
                            <div class="input-icon-group">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required autocomplete="name">
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Surel (Email) -->
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold" for="email">Alamat Surel (Email)</label>
                            <div class="input-icon-group">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary btn-round px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card 2: Update Password -->
            <div class="card info-card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-primary font-weight-bold m-0">
                        <i class="fas fa-key me-2"></i> Ubah Kata Sandi
                    </h5>
                </div>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <p class="text-secondary mb-4" style="font-size: 0.85rem;">
                            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan akun
                            dari pihak luar.
                        </p>

                        <!-- Password Lama -->
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold" for="update_password_current_password">Kata Sandi
                                Saat Ini</label>
                            <div class="input-icon-group">
                                <i class="fas fa-lock-open"></i>
                                <input type="password" name="current_password" id="update_password_current_password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    autocomplete="current-password">
                                <button type="button" class="btn-show-password"
                                    onclick="togglePasswordVisibility('update_password_current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold" for="update_password_password">Kata Sandi
                                Baru</label>
                            <div class="input-icon-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" id="update_password_password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    autocomplete="new-password">
                                <button type="button" class="btn-show-password"
                                    onclick="togglePasswordVisibility('update_password_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold"
                                for="update_password_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <div class="input-icon-group">
                                <i class="fas fa-shield-alt"></i>
                                <input type="password" name="password_confirmation"
                                    id="update_password_password_confirmation"
                                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                    autocomplete="new-password">
                                <button type="button" class="btn-show-password"
                                    onclick="togglePasswordVisibility('update_password_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary btn-round px-4">
                            <i class="fas fa-key me-1"></i> Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot:myScript>
        {{-- ? toastify library  --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <script>
            function togglePasswordVisibility(inputId) {
                var input = document.getElementById(inputId);
                var button = input.nextElementSibling;
                var icon = button.querySelector('i');

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            // Display standard Breeze success status if redirected back
            @if (session('status') === 'profile-updated')
                Toastify({
                    text: "Profil Anda berhasil diperbarui!",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745",
                }).showToast();
            @endif

            @if (session('status') === 'password-updated')
                Toastify({
                    text: "Kata sandi Anda berhasil diubah!",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745",
                }).showToast();
            @endif
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
