<x-dashboard.layoutDashboard.app title="Ubah Mata Pelajaran">
    {{-- * my style --}}
    <x-slot:myStyle>

    </x-slot:myStyle>
    {{-- * my style --}}

    {{-- todo content ... --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ubah Mata Pelajaran</h4>
        </div>

        <form action="{{ route('dashboard.mata-pelajaran.update', $mataPelajaran) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <x-dashboard.input
                            label="Nama Mata Pelajaran"
                            name="nama"
                            value="{{ old('nama', $mataPelajaran->nama) }}"
                            placeholder="Masukkan Nama Mata Pelajaran"
                        />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <x-dashboard.input-textarea
                            label="Deskripsi"
                            name="deskripsi"
                            rows="5"
                            value="{{ old('deskripsi', $mataPelajaran->deskripsi) }}"
                            placeholder="Masukkan Deskripsi Mata Pelajaran"
                        />
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('dashboard.mata-pelajaran.index') }}" class="btn btn-danger">Kembali</a>
            </div>
        </form>
    </div>
    {{-- todo content ... --}}

    {{-- * my script --}}
    <x-slot:myScript>
        
    </x-slot:myScript>
    {{-- * my script --}}
</x-dashboard.layoutDashboard.app>
