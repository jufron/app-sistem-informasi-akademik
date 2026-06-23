<x-dashboard.layoutDashboard.app title="Daftar Ruangan Kelas">
    <x-slot:myStyle>
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        
        <style>
            .filter-card {
                background: #ffffff;
                border: 1px solid #ebedf2;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            }
            .filter-title {
                font-size: 0.95rem;
                font-weight: 700;
                color: #212529;
            }
            .btn-view-class-details {
                background: linear-gradient(135deg, #1572e8 0%, #064fa9 100%);
                border: none;
                color: white !important;
                font-weight: 600;
                border-radius: 30px !important;
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            .btn-view-class-details:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(21, 114, 232, 0.35) !important;
            }
        </style>
    </x-slot:myStyle>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="card-title font-weight-bold text-dark m-0">
                        <i class="fas fa-school text-primary me-2"></i> Ruangan Kelas Sekolah
                    </h4>
                    <p class="card-category text-muted m-0 mt-1">Daftar ruangan kelas aktif, tahun ajaran, dan kapasitas siswa terdaftar.</p>
                </div>
                <div class="card-body">
                    <!-- Filters Section -->
                    <div class="filter-card p-4 mb-4">
                        <div class="filter-title mb-3 d-flex align-items-center justify-content-between">
                            <span class="d-flex align-items-center font-weight-bold">
                                <i class="fa fa-filter text-primary me-2"></i> Filter Data Ruangan Kelas
                            </span>
                            <button type="button" id="btn-reset-filter" class="btn btn-sm btn-outline-secondary btn-round px-3">
                                <i class="fas fa-undo me-1"></i> Reset Filter
                            </button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="filter-kelas" class="form-label font-weight-bold text-dark" style="font-size: 0.85rem;">Kelas</label>
                                <select id="filter-kelas" class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter-rombel" class="form-label font-weight-bold text-dark" style="font-size: 0.85rem;">Rombongan Belajar</label>
                                <select id="filter-rombel" class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option value="">Semua Rombongan</option>
                                    @foreach ($rombel as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filter-semester" class="form-label font-weight-bold text-dark" style="font-size: 0.85rem;">Semester</label>
                                <select id="filter-semester" class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option value="">Semua Semester</option>
                                    @foreach ($semester as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-striped table-hover mt-4 w-100'], true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:myScript>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

        {!! $dataTable->scripts() !!}

        <script>
            jQuery(function($) {
                var tableId = 'ruangankelas-table';
                var table = null;

                $(document).ready(function() {
                    table = window.LaravelDataTables && window.LaravelDataTables[tableId];
                    if (table) {
                        table.on('preXhr.dt', function(e, settings, data) {
                            data.kelas_id = $('#filter-kelas').val();
                            data.rombel_id = $('#filter-rombel').val();
                            data.semester_id = $('#filter-semester').val();
                        });
                    }
                });

                // Trigger redraw when any filter dropdown value changes
                $('#filter-kelas, #filter-rombel, #filter-semester').on('change', function() {
                    if (table) {
                        table.draw();
                    }
                });

                // Reset filter action
                $('#btn-reset-filter').on('click', function() {
                    $('#filter-kelas').val('');
                    $('#filter-rombel').val('');
                    $('#filter-semester').val('');
                    if (table) {
                        table.draw();
                    }
                });
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
