<x-dashboard.layoutDashboard.app title="Dashboard Kepala Sekolah">
    <x-slot:myStyle>
        <style>
            .welcome-card {
                background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%);
                color: #ffffff;
                border-radius: 16px;
                border: none;
                position: relative;
                overflow: hidden;
            }

            .welcome-card::after {
                content: '';
                position: absolute;
                width: 250px;
                height: 250px;
                background: rgba(255, 255, 255, 0.15);
                border-radius: 50%;
                top: -60px;
                right: -60px;
                z-index: 1;
            }

            .welcome-card::before {
                content: '';
                position: absolute;
                width: 150px;
                height: 150px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                bottom: -40px;
                right: 80px;
                z-index: 1;
            }

            .welcome-content {
                position: relative;
                z-index: 2;
            }

            .stat-card {
                border-radius: 16px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid #ebedf2;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
            }

            .icon-wrapper {
                width: 54px;
                height: 54px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .chart-card {
                border-radius: 16px;
                border: 1px solid #ebedf2;
            }

            .theme-chart {
                min-height: 330px;
            }
        </style>
    </x-slot:myStyle>

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card welcome-card shadow-sm p-4">
                <div class="welcome-content py-2">
                    <h2 class="font-weight-bold mb-2">Selamat Datang Kepala Sekolah!</h2>
                    <p class="mb-0 opacity-80" style="font-size: 0.95rem;">
                        Panel pemantauan akademik sekolah. Di sini Anda dapat memantau indikator statistik, sebaran data siswa, serta jalannya kegiatan pembelajaran di sekolah secara berkala.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: 6 Core Dynamic Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Siswa -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-primary-light text-primary mx-auto mb-3"
                        style="background-color: rgba(21, 114, 232, 0.1);">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalSiswa }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Siswa</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Guru -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-success-light text-success mx-auto mb-3"
                        style="background-color: rgba(40, 167, 69, 0.1);">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalGuru }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Guru & Staf</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Mata Pelajaran -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-warning-light text-warning mx-auto mb-3"
                        style="background-color: rgba(255, 193, 7, 0.15);">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalMapel }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Mata Pelajaran</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Ruangan Kelas -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-info-light text-info mx-auto mb-3"
                        style="background-color: rgba(23, 162, 184, 0.1);">
                        <i class="fas fa-school fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalRuangan }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Kelas & Ruangan</p>
                </div>
            </div>
        </div>

        <!-- Card 5: Rombongan Belajar -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-danger-light text-danger mx-auto mb-3"
                        style="background-color: rgba(220, 53, 69, 0.1);">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalRombel }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Rombel</p>
                </div>
            </div>
        </div>

        <!-- Card 6: Jadwal Pelajaran -->
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card border-0 shadow-sm bg-white h-100">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-secondary-light text-secondary mx-auto mb-3"
                        style="background-color: rgba(108, 117, 125, 0.1);">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">{{ $totalJadwal }}</h3>
                    <p class="text-secondary font-weight-bold mb-0"
                        style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Slot Jadwal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Dynamic Charts (ApexCharts) -->
    <div class="row g-4 mb-4">
        <!-- Left Chart: Status Keanggotaan Siswa (Spline Area / Column) -->
        <div class="col-lg-7">
            <div class="card chart-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-chart-area text-primary me-2"></i> Grafik Status Keanggotaan Siswa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div id="statusSiswaChart" class="theme-chart"></div>
                </div>
            </div>
        </div>

        <!-- Right Chart: Penyebaran Gender Siswa (Donut Chart) -->
        <div class="col-lg-5">
            <div class="card chart-card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-dark font-weight-bold m-0">
                        <i class="fas fa-chart-pie text-success me-2"></i> Sebaran Jenis Kelamin Siswa
                    </h5>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div id="genderSiswaChart" class="w-100 theme-chart" style="max-width: 380px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Block -->
    <x-slot:myScript>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // 1. Gender Donut Chart
                var genderLabels = @json($genderData->pluck('name'));
                var genderTotals = @json($genderData->pluck('total')->map(fn($v) => (int) $v));

                var genderOptions = {
                    series: genderTotals.length > 0 ? genderTotals : [0],
                    labels: genderLabels.length > 0 ? genderLabels : ["Tidak Ada Data"],
                    chart: {
                        type: 'donut',
                        height: 330,
                        fontFamily: 'inherit'
                    },
                    colors: ['#007bff', '#e83e8c', '#fd7e14', '#28a745'],
                    legend: {
                        position: 'bottom',
                        fontSize: '12px'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '14px',
                                        fontWeight: 600
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '20px',
                                        fontWeight: 700,
                                        formatter: function(val) {
                                            return val + " Siswa";
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total Siswa',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + " Siswa";
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
                var genderChart = new ApexCharts(document.querySelector("#genderSiswaChart"), genderOptions);
                genderChart.render();

                // 2. Status Area Chart
                var statusLabels = @json($statusData->pluck('name'));
                var statusTotals = @json($statusData->pluck('total')->map(fn($v) => (int) $v));

                var statusOptions = {
                    series: [{
                        name: 'Jumlah Siswa',
                        data: statusTotals.length > 0 ? statusTotals : [0]
                    }],
                    chart: {
                        type: 'area',
                        height: 330,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit'
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    colors: ['#1171ef'],
                    xaxis: {
                        categories: statusLabels.length > 0 ? statusLabels : ["Tidak Ada Data"],
                        labels: {
                            style: {
                                fontWeight: 500
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return Math.round(val);
                            }
                        }
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                        strokeDashArray: 4
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " Siswa";
                            }
                        }
                    }
                };
                var statusChart = new ApexCharts(document.querySelector("#statusSiswaChart"), statusOptions);
                statusChart.render();
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
