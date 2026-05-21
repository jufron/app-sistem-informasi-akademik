<x-dashboard.layoutDashboard.app title="Tambah Mata Pelajaran">
    {{-- * my style --}}
    <x-slot:myStyle>

    </x-slot:myStyle>
    {{-- * my style --}}

    {{-- todo content ... --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Mata Pelajaran</h4>
        </div>

        <form action="{{ route('dashboard.mata-pelajaran.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <x-dashboard.input
                            label="Nama Mata Pelajaran"
                            name="nama"
                            value="{{ old('nama') }}"
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
                            value="{{ old('deskripsi') }}"
                            placeholder="Masukkan Deskripsi Mata Pelajaran"
                        />
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-success">Simpan</button>
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