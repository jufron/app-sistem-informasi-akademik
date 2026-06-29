<x-dashboard.layoutDashboard.app title="Ubah Siswa">
    <x-slot:myStyle>
        <style>
            .preview-img-container {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 3px solid #1572e8;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin: 0 auto 15px auto;
                background-color: #f8f9fa;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
            .preview-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ubah Data Siswa</h4>
        </div>

        <form action="{{ route('dashboard.siswa.update', $siswa) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                
                <!-- Section 1: Akun Pengguna -->
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-user-lock me-2"></i> Kredensial Akun</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-dashboard.input
                            label="Email Siswa"
                            name="email"
                            type="email"
                            value="{{ old('email', $siswa->user->email) }}"
                            placeholder="Masukkan Email Siswa"
                        />
                    </div>
                    <div class="col-md-6 mb-3">
                        <x-dashboard.input
                            label="Password (Kosongkan jika tidak ingin diubah)"
                            name="password"
                            type="password"
                            placeholder="Masukkan Password Baru"
                        />
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <!-- Section 2: Profil & Biodata -->
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-id-card me-2"></i> Biodata Lengkap</h5>
                <div class="row">
                    <!-- Foto Preview & Upload -->
                    <div class="col-md-3 mb-3 text-center border-end">
                        <div class="form-group p-0">
                            <label class="form-label d-block mb-3">Foto Siswa</label>
                            <div class="preview-img-container">
                                @if($siswa->foto)
                                    <img id="img-preview" src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="preview-img">
                                @else
                                    <img id="img-preview" src="https://www.gravatar.com/avatar/{{ md5(trim(strtolower($siswa->user->email))) }}?d=mp&s=150" alt="Preview Foto" class="preview-img">
                                @endif
                            </div>
                            <input type="file" name="foto" id="foto-input" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Maks. 2MB (JPG, PNG, WEBP)</small>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="NISN (Nomor Induk Siswa Nasional)"
                                    name="nisn"
                                    value="{{ old('nisn', $siswa->nisn) }}"
                                    placeholder="Masukkan NISN Siswa"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="NIS (Nomor Induk Siswa)"
                                    name="nis"
                                    value="{{ old('nis', $siswa->nis) }}"
                                    placeholder="Masukkan NIS Siswa"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Nama Lengkap"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                                    placeholder="Masukkan Nama Lengkap Siswa"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Nama Panggilan"
                                    name="nama_panggilan"
                                    value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}"
                                    placeholder="Masukkan Nama Panggilan"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group @error('jenis_kelamin_id') has-error @enderror">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin_id') is-invalid @enderror" name="jenis_kelamin_id">
                                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                        @foreach($jenisKelamin as $jk)
                                            <option value="{{ $jk->id }}" {{ old('jenis_kelamin_id', $siswa->jenis_kelamin_id) == $jk->id ? 'selected' : '' }}>
                                                {{ $jk->nama }} ({{ $jk->kode }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kelamin_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group @error('agama_id') has-error @enderror">
                                    <label class="form-label">Agama</label>
                                    <select class="form-select @error('agama_id') is-invalid @enderror" name="agama_id">
                                        <option value="" disabled>-- Pilih Agama --</option>
                                        @foreach($agama as $a)
                                            <option value="{{ $a->id }}" {{ old('agama_id', $siswa->agama_id) == $a->id ? 'selected' : '' }}>
                                                {{ $a->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('agama_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Nomor Telepon"
                                    name="telepon"
                                    value="{{ old('telepon', $siswa->telepon) }}"
                                    placeholder="Masukkan Nomor Telepon Aktif (Opsional)"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Tempat Lahir"
                                    name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                    placeholder="Masukkan Tempat Lahir"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Tanggal Lahir"
                                    name="tanggal_lahir"
                                    type="date"
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group @error('status') has-error @enderror">
                                    <label class="form-label">Status Keaktifan</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                                        <option value="Aktif" {{ old('status', $siswa->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Nonaktif" {{ old('status', $siswa->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="Cuti" {{ old('status', $siswa->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mb-3">
                        <x-dashboard.input-textarea
                            label="Alamat Lengkap"
                            name="alamat"
                            rows="4"
                            value="{{ old('alamat', $siswa->alamat) }}"
                            placeholder="Masukkan Alamat Lengkap Siswa"
                        />
                    </div>
                </div>

            </div>
            
            <div class="card-action">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('dashboard.siswa.index') }}" class="btn btn-danger">Kembali</a>
            </div>
        </form>
    </div>

    <x-slot:myScript>
        <script>
            // Live image upload preview
            document.getElementById('foto-input').addEventListener('change', function(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('img-preview');
                    output.src = reader.result;
                };
                if(event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
