<x-dashboard.layoutDashboard.app title="Home">
    {{-- * my style --}}
    <x-slot:myStyle>

    </x-slot:myStyle>

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h1 class="fw-bold mb-3 text-uppercase">Dashboard</h1>
        </div>
    </div>
    {{-- ? mini card --}}
    <div class="row">
        {{-- ? count kategory berita --}}
        <div class="col-6 col-sm-4 col-lg-2 col-xl-3">
          <div class="card">
            <div class="card-body p-3 text-center">
              <div class="h1 m-0">asd</div>
              <div class="text-muted mb-3">Kategori Berita</div>
            </div>
          </div>
        </div>
        {{-- ? count foto galeri --}}
        <div class="col-6 col-sm-4 col-lg-2 col-xl-3">
          <div class="card">
            <div class="card-body p-3 text-center">
              <div class="h1 m-0">asd</div>
              <div class="text-muted mb-3">Foto Galeri</div>
            </div>
          </div>
        </div>
        {{-- ? count guru & staf --}}
        <div class="col-6 col-sm-4 col-lg-2 col-xl-3">
          <div class="card">
            <div class="card-body p-3 text-center">
              <div class="h1 m-0">asd</div>
              <div class="text-muted mb-3">Guru & Staf</div>
            </div>
          </div>
        </div>
        {{-- ? count siswa prestasi --}}
        <div class="col-6 col-sm-4 col-lg-2 col-xl-3">
          <div class="card">
            <div class="card-body p-3 text-center">
              <div class="h1 m-0">asd</div>
              <div class="text-muted mb-3">Siswa Prestasi</div>
            </div>
          </div>
        </div>
    </div>

    {{-- todo count beita --}}
    <div class="row row-card-no-pd">
        {{-- ? count all berita --}}
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-newspaper text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total Berita</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count berita publish --}}
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-newspaper text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Berita Publish</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count berita draft --}}
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-newspaper text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Berita Draft</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- todo count testimoni --}}
    <div class="row row-card-no-pd">
        {{-- ? count all testimoni --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-comments text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total Testimoni</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count testimoni masuk bulan --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-comments text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Testimoni Masuk</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count testimoni publish --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-comments text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Testimoni Publish</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count testimoni draft --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-comments text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Testimoni Draft</p>
                                <h4 class="card-title">asd</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- todo count ppdb --}}
    <div class="row">
        {{-- ? count all ppdb --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Seluruh PPDB</p>
                                <h4 class="card-title">20</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count ppdb gelombang 1 --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-info card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">PPDB Gelombang 1</p>
                                <h4 class="card-title">14</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count ppdb gelombang 2 --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-success card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">PPDB Gelombang 2</p>
                                <h4 class="card-title">16</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? count ppdb gelombang 3 --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-secondary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">PPDB Gelombang 3</p>
                                <h4 class="card-title">32</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ? chart statistic --}}
    <div class="row">
        {{-- ? chart 1 --}}
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Statistik Tahunan PPDB</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <div id="areaChart" class="chartjs-render-monitor">

                        </div>
                    </div>
                    {{-- <div id="myChartLegend"><ul class="0-legend html-legend"><li><span style="background-color:#f3545d"></span>Subscribers</li><li><span style="background-color:#fdaf4b"></span>New Visitors</li><li><span style="background-color:#177dff"></span>Active Users</li></ul></div> --}}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- ? chart 3 --}}
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">PPDB Jenis Kelamin 2025</div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="pull-in"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <div id="jenisKelaminChart" class="chartjs-render-monitor"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- ? chart 2 --}}
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">PPDB Agama 2025</div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="pull-in"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <div id="agamaChart" class="chartjs-render-monitor"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- * my script --}}
    <x-slot:myScript>

        {{-- ? apex chart lib --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script src="{{ asset('js/ppdbChart.js') }}"></script>
        <script src="{{ asset('js/agamaChart.js') }}"></script>
        <script src="{{ asset('js/jenisKelaminChart.js') }}"></script>

    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
