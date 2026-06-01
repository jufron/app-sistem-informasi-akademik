<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        {{-- ? Logo Header --}}
        <x-dashboard.layoutDashboard.logo-header />
        {{-- ? End Logo Header --}}
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                {{-- ? dashboard --}}
                <li @class(['nav-item', 'active' => request()->routeIs('dashboard')])>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashobard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <h4 class="text-section">Akademik</h4>
                </li>

                @role('admin')
                    {{-- ? menu mata pelajaran --}}
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.mata-pelajaran.index'),
                    ])>
                        <a href="{{ route('dashboard.mata-pelajaran.index') }}">
                            <i class="fas fa-th-list"></i>
                            <p>Mata Pelajaran</p>
                        </a>
                    </li>

                    {{-- ? siswa --}}

                    {{-- ?  guru --}}
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.guru.*'),
                    ])>
                        <a href="{{ route('dashboard.guru.index') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <p>Guru</p>
                        </a>
                    </li>

                    {{-- ? kelas --}}
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.ruangan-kelas.*'),
                    ])>
                        <a href="{{ route('dashboard.ruangan-kelas.index') }}">
                            <i class="fas fa-school"></i>
                            <p>Ruangan Kelas</p>
                        </a>
                    </li>


                    {{-- ? jadwal pelajaran --}}
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.jadwal-pelajaran.*'),
                    ])>
                        <a href="{{ route('dashboard.jadwal-pelajaran.index') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Jadwal Pelajaran</p>
                        </a>
                    </li>
                    {{-- ? laporan akademik --}}
                @endrole

                {{-- ? galeri foto --}}
                @role('guru')
                    {{-- <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.galery-foto.index')
                    ])>
                        <a href="{{ route('dashboard.galery-foto.index') }}">
                        <i class="fas fa-th-list"></i>
                        <p>Galeri Foto</p>
                    </a>
                </li> --}}
                    {{-- ? input nilai masing maing guru berdasarkan mata pelajaran --}}
                @endrole

                @role('kepala-sekolah')
                    {{-- <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.galery-foto.index')
                    ])>
                        <a href="{{ route('dashboard.galery-foto.index') }}">
                        <i class="fas fa-th-list"></i>
                        <p>Galeri Foto</p>
                    </a>
                </li> --}}
                    {{-- ? menerima laporan penilaian --}}
                @endrole

                @role('siswa')
                    {{-- <li @class([
                        'nav-item',
                        'active' => request()->routeIs('dashboard.galery-foto.index')
                    ])>
                        <a href="{{ route('dashboard.galery-foto.index') }}">
                        <i class="fas fa-th-list"></i>
                        <p>Galeri Foto</p>
                    </a>
                </li> --}}
                @endrole

                {{-- ? manajement berita --}}
                {{-- @if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('kesiswaan'))
                <x-dashboard.linkMenu-dropdown
                    id="manajement-berita"
                    title="Manajement Berita"
                    :routes="[
                        'dashboard.kategory.index',
                        'dashboard.kategory.create',
                        'dashboard.kategory.edit',
                        'dashboard.berita.index',
                        'dashboard.berita.create',
                        'dashboard.berita.edit',
                    ]"
                    :items="[
                        [
                            'label' => 'Kategory',
                            'route' => 'dashboard.kategory.index',
                            'routes' => [
                                'dashboard.kategory.index',
                                'dashboard.kategory.create',
                                'dashboard.kategory.edit'
                            ]
                        ],
                        [
                            'label' => 'Berita',
                            'route' => 'dashboard.berita.index',
                            'routes' => [
                                'dashboard.berita.index',
                                'dashboard.berita.create',
                                'dashboard.berita.edit'
                            ]
                        ],
                    ]"
                />
                @endif --}}

                <li class="nav-section">
                    <h4 class="text-section">Akademik</h4>
                </li>

                {{-- ? akademik --}}
                {{-- @role('superadmin')
                <x-dashboard.linkMenu-dropdown
                    id="akademik"
                    title="Akademik"
                    :routes="[
                        'dashboard.guru-staf.index',
                        'dashboard.guru-staf.create',
                        'dashboard.guru-staf.edit',
                        'dashboard.testimoni.index',
                        'dashboard.testimoni.create',
                        'dashboard.testimoni.edit',
                        'dashboard.siswa-berprestasi.index',
                        'dashboard.siswa-berprestasi.create',
                        'dashboard.siswa-berprestasi.edit',
                    ]"
                    :items="[
                        [
                            'label' => 'Guru & Staf',
                            'route' => 'dashboard.guru-staf.index',
                            'routes' => [
                                'dashboard.guru-staf.index',
                                'dashboard.guru-staf.create',
                                'dashboard.guru-staf.edit',
                            ]
                        ],
                        [
                            'label' => 'Testimoni',
                            'route' => 'dashboard.testimoni.index',
                            'routes' => [
                                'dashboard.testimoni.index',
                                'dashboard.testimoni.create',
                                'dashboard.testimoni.edit'
                            ]
                        ],
                        [
                            'label' => 'Siswa Berprestasi',
                            'route' => 'dashboard.siswa-berprestasi.index',
                            'routes' => [
                                'dashboard.siswa-berprestasi.index',
                                'dashboard.siswa-berprestasi.create',
                                'dashboard.siswa-berprestasi.edit',
                            ]
                        ]
                    ]"
                />
                @endrole --}}
                {{-- @role('kesiswaan')
                <x-dashboard.linkMenu-dropdown
                    id="akademik"
                    title="Akademik"
                    :routes="[
                        'dashboard.testimoni.index',
                        'dashboard.testimoni.create',
                        'dashboard.testimoni.edit',
                    ]"
                    :items="[
                        [
                            'label' => 'Testimoni',
                            'route' => 'dashboard.testimoni.index',
                            'routes' => [
                                'dashboard.testimoni.index',
                                'dashboard.testimoni.create',
                                'dashboard.testimoni.edit'
                            ]
                        ],
                    ]"
                />
                @endrole --}}

                <li class="nav-section">
                    <h4 class="text-section">Peserta Didik Baru</h4>
                </li>

                {{-- ? ppdb --}}
                {{-- @role('superadmin')
                <x-dashboard.linkMenu-dropdown
                    id="ppdb"
                    title="PPDB"
                    :routes="[
                        'dashboard.penerimaan-peserta-didik-baru.index',
                        'dashboard.penerimaan-peserta-didik-baru.create',
                        'dashboard.penerimaan-peserta-didik-baru.edit',
                        'dashboard.daftar-pertanyaan-ppdb.index',
                        'dashboard.daftar-pertanyaan-ppdb.create',
                        'dashboard.daftar-pertanyaan-ppdb.edit',
                    ]"
                    :items="[
                        [
                            'label' => 'Daftar Siswa Baru',
                            'route' => 'dashboard.penerimaan-peserta-didik-baru.index',
                            'routes' => [
                                'dashboard.penerimaan-peserta-didik-baru.index',
                                'dashboard.penerimaan-peserta-didik-baru.create',
                                'dashboard.penerimaan-peserta-didik-baru.edit'
                            ]
                        ],
                        [
                            'label' => 'Pertanyaan PPDB',
                            'route' => 'dashboard.daftar-pertanyaan-ppdb.index',
                            'routes' => [
                                'dashboard.daftar-pertanyaan-ppdb.index',
                                'dashboard.daftar-pertanyaan-ppdb.create',
                                'dashboard.daftar-pertanyaan-ppdb.edit'
                            ]
                        ],
                    ]"
                />
                @endrole --}}
            </ul>
        </div>
    </div>
</div>
