<x-dashboard.layoutDashboard.app title="Ubah Guru">
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
            .subject-card {
                border: 1px solid #ebedf2;
                border-radius: 8px;
                padding: 10px 15px;
                transition: all 0.2s ease;
                background: #fafafa;
                cursor: pointer;
            }
            .subject-card:hover {
                border-color: #1572e8;
                background: #f1f7ff;
            }
            .subject-card input[type="checkbox"] {
                cursor: pointer;
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ubah Data Guru</h4>
        </div>

        <form action="{{ route('dashboard.guru.update', $guru) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                
                <!-- Section 1: Akun Pengguna -->
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-user-lock me-2"></i> Kredensial Akun</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-dashboard.input
                            label="Email Guru"
                            name="email"
                            type="email"
                            value="{{ old('email', $guru->user->email) }}"
                            placeholder="Masukkan Email Guru"
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
                            <label class="form-label d-block mb-3">Foto Guru</label>
                            <div class="preview-img-container">
                                @if($guru->foto)
                                    <img id="img-preview" src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Guru" class="preview-img">
                                @else
                                    <img id="img-preview" src="https://www.gravatar.com/avatar/{{ md5(trim(strtolower($guru->user->email))) }}?d=mp&s=150" alt="Preview Foto" class="preview-img">
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
                                    label="NIP (Nomor Induk Pegawai)"
                                    name="nip"
                                    value="{{ old('nip', $guru->nip) }}"
                                    placeholder="Masukkan NIP Guru"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Nama Lengkap & Gelar"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $guru->nama_lengkap) }}"
                                    placeholder="Masukkan Nama Lengkap Beserta Gelar"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Nama Panggilan"
                                    name="nama_panggilan"
                                    value="{{ old('nama_panggilan', $guru->nama_panggilan) }}"
                                    placeholder="Masukkan Nama Panggilan"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group @error('jenis_kelamin_id') has-error @enderror">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin_id') is-invalid @enderror" name="jenis_kelamin_id">
                                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                        @foreach($jenisKelamin as $jk)
                                            <option value="{{ $jk->id }}" {{ old('jenis_kelamin_id', $guru->jenis_kelamin_id) == $jk->id ? 'selected' : '' }}>
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
                                            <option value="{{ $a->id }}" {{ old('agama_id', $guru->agama_id) == $a->id ? 'selected' : '' }}>
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
                                    value="{{ old('telepon', $guru->telepon) }}"
                                    placeholder="Masukkan Nomor Telepon Aktif"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Tempat Lahir"
                                    name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $guru->tempat_lahir) }}"
                                    placeholder="Masukkan Tempat Lahir"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-dashboard.input
                                    label="Tanggal Lahir"
                                    name="tanggal_lahir"
                                    type="date"
                                    value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}"
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group @error('tipe') has-error @enderror">
                                    <label class="form-label">Tipe Jabatan</label>
                                    <select class="form-select @error('tipe') is-invalid @enderror" name="tipe">
                                        <option value="Bukan Wali Kelas" {{ old('tipe', $guru->tipe) == 'Bukan Wali Kelas' ? 'selected' : '' }}>Bukan Wali Kelas</option>
                                        <option value="Wali Kelas" {{ old('tipe', $guru->tipe) == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                                        @if(!$hasKepalaSekolah || $guru->tipe === 'Kepala Sekolah')
                                            <option value="Kepala Sekolah" {{ old('tipe', $guru->tipe) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                        @endif
                                    </select>
                                    @error('tipe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group @error('status') has-error @enderror">
                                    <label class="form-label">Status Keaktifan</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                                        <option value="Aktif" {{ old('status', $guru->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Nonaktif" {{ old('status', $guru->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="Cuti" {{ old('status', $guru->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
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
                            value="{{ old('alamat', $guru->alamat) }}"
                            placeholder="Masukkan Alamat Lengkap Guru"
                        />
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <!-- Section 3: Mengampu Mata Pelajaran -->
                <h5 class="text-primary font-weight-bold mb-3"><i class="fa fa-book-open me-2"></i> Mengampu Mata Pelajaran</h5>
                <p class="text-muted mb-3">Pilih mata pelajaran yang diajarkan oleh guru ini (bisa memilih lebih dari satu):</p>
                
                @error('mata_pelajaran_ids')
                    <div class="alert alert-danger p-2 mb-3">{{ $message }}</div>
                @enderror

                <div class="row">
                    @foreach($mataPelajaran as $subject)
                        <div class="col-md-4 mb-3">
                            <label class="subject-card d-flex align-items-center m-0 w-100">
                                <input type="checkbox" name="mata_pelajaran_ids[]" value="{{ $subject->id }}" class="form-check-input me-3"
                                    {{ (is_array(old('mata_pelajaran_ids')) && in_array($subject->id, old('mata_pelajaran_ids'))) || (!is_array(old('mata_pelajaran_ids')) && $guru->mataPelajaran->contains($subject->id)) ? 'checked' : '' }}>
                                <div>
                                    <div class="font-weight-bold text-dark">{{ $subject->nama }}</div>
                                    <small class="text-secondary">{{ str($subject->deskripsi)->limit(35) }}</small>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

            </div>
            
            <div class="card-action">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('dashboard.guru.index') }}" class="btn btn-danger">Kembali</a>
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
