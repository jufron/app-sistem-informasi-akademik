<x-dashboard.layoutDashboard.app title="Jadwal Pelajaran">
    <x-slot:myStyle>
        {{-- ? sweetalert 2 lib --}}
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

        {{-- ? toastify css  --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- DataTables & Buttons Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

        <!-- FullCalendar 6 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

        <!-- Premium Customs for Calendar and Inputs -->
        <style>
            .row-checkbox,
            #select-all {
                width: 1.3rem !important;
                height: 1.3rem !important;
                cursor: pointer;
                border: 2px solid #ced4da !important;
                border-radius: 4px !important;
                transition: all 0.2s ease-in-out;
                vertical-align: middle;
            }

            .row-checkbox:hover,
            #select-all:hover {
                border-color: #1572e8 !important;
                box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
            }

            .row-checkbox:checked,
            #select-all:checked {
                background-color: #1572e8 !important;
                border-color: #1572e8 !important;
                transform: scale(1.1);
            }

            /* Premium Calendar adjustments */
            #calendar {
                background: #ffffff;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .calendar-wrapper {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 12px;
                padding-bottom: 5px;
            }

            /* Premium Custom Scrollbar for Calendar Wrapper */
            .calendar-wrapper::-webkit-scrollbar {
                height: 8px;
            }

            .calendar-wrapper::-webkit-scrollbar-track {
                background: #f1f2f7;
                border-radius: 10px;
            }

            .calendar-wrapper::-webkit-scrollbar-thumb {
                background: #1572e8;
                border-radius: 10px;
                border: 2px solid #f1f2f7;
            }

            .calendar-wrapper::-webkit-scrollbar-thumb:hover {
                background: #0d5ec4;
            }

            .fc-event {
                cursor: pointer;
                border-radius: 6px !important;
                padding: 4px 6px;
                border: none !important;
                transition: all 0.2s ease;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            }

            .fc-event:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .fc-event-title {
                font-weight: 600 !important;
                font-size: 0.85rem !important;
                white-space: normal !important;
                line-height: 1.3 !important;
            }

            .fc-timegrid-event .fc-event-time {
                font-size: 0.75rem !important;
                margin-bottom: 2px;
                opacity: 0.9;
            }

            .fc-theme-standard td,
            .fc-theme-standard th {
                border-color: #f1f2f7 !important;
            }

            .fc-col-header-cell {
                background: #f8f9fa;
                padding: 10px 0 !important;
            }

            .fc-col-header-cell-cushion {
                color: #495057 !important;
                font-weight: 700 !important;
                text-decoration: none !important;
            }

            /* Responsive styles for Mobile & Tablet */
            @media (max-width: 991.98px) {
                #calendar {
                    min-width: 900px;
                    /* Ensures calendar grid is readable and non-squished */
                    padding: 12px;
                }

                .fc-event-title {
                    font-size: 0.75rem !important;
                }

                .fc-timegrid-event .fc-event-time {
                    font-size: 0.65rem !important;
                }

                .fc-col-header-cell {
                    padding: 6px 0 !important;
                }

                .fc-timegrid-slot {
                    height: 2.5rem !important;
                    /* Slightly taller slots on mobile for better touch targeting */
                }
            }

            /* Premium SweetAlert2 Custom Styling */
            .swal2-premium-modal {
                border-radius: 16px !important;
                padding: 1.5rem !important;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
                background: #ffffff !important;
            }

            .swal2-premium-modal .swal2-title {
                font-size: 1.3rem !important;
                font-weight: 700 !important;
                color: #1a202c !important;
                padding-bottom: 8px !important;
                border-bottom: 2px solid #eef2f6 !important;
                margin-bottom: 1rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .swal2-premium-modal .swal2-html-container {
                margin: 0 !important;
                overflow-x: hidden !important;
            }

            .swal2-premium-modal .swal2-actions {
                margin-top: 1.5rem !important;
                border-top: 1px solid #eef2f6 !important;
                padding-top: 1rem !important;
                width: 100% !important;
                justify-content: center !important;
            }

            /* Premium Detail Cards */
            .detail-card {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 10px 14px;
                transition: all 0.2s ease-in-out;
                display: flex;
                align-items: center;
                text-align: left;
            }

            .detail-card:hover {
                background: #f1f5f9;
                transform: translateY(-1px);
                border-color: #cbd5e1;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .detail-icon {
                font-size: 1.1rem;
                color: #1572e8;
                background: rgba(21, 114, 232, 0.1);
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                margin-right: 12px;
                flex-shrink: 0;
            }

            .detail-content {
                flex-grow: 1;
                min-width: 0;
            }

            .detail-label {
                font-size: 0.68rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #64748b;
                font-weight: 700;
                margin-bottom: 2px;
            }

            .detail-value {
                font-size: 0.85rem;
                font-weight: 600;
                color: #1e293b;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .detail-value.wrap {
                white-space: normal;
                word-break: break-word;
            }

            .detail-badge {
                font-size: 0.72rem;
                font-weight: 700;
                padding: 3px 8px;
                border-radius: 6px;
                background: rgba(21, 114, 232, 0.1);
                color: #1572e8;
                display: inline-block;
            }
        </style>
    </x-slot:myStyle>

    <!-- Top Card: FullCalendar Interactive Roster -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex flex-column flex-md-row align-items-md-center justify-content-between py-3 gap-2"
            style="border-top-left-radius: 8px; border-top-right-radius: 8px;">
            <h4 class="card-title text-white mb-0"><i class="fa fa-calendar-alt me-2"></i> Roster Jadwal Pelajaran
                Mingguan</h4>
            <span class="badge bg-white text-primary px-3 py-2 font-weight-bold text-nowrap">Mode Interaktif</span>
        </div>
        <div class="card-body p-4 bg-light">
            <!-- Mobile Navigation / Scroll Hint -->
            <div class="d-md-none mb-3">
                <div
                    class="d-flex align-items-center justify-content-center bg-white p-2 rounded-3 shadow-sm border border-light">
                    <span class="spinner-grow spinner-grow-sm text-primary me-2" role="status" aria-hidden="true"
                        style="width: 8px; height: 8px;"></span>
                    <i class="fa fa-arrows-alt-h text-primary me-2"></i>
                    <small class="text-secondary fw-semibold">Geser kalender ke kanan/kiri untuk jadwal lengkap</small>
                </div>
            </div>

            <div class="calendar-wrapper">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Card: DataTable Roster List & Actions -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fa fa-list me-2"></i> Pengaturan & Daftar Roster</h4>
        </div>
        <div class="card-body">
            <div class="my-4">
                <a href="{{ route('dashboard.jadwal-pelajaran.create') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i> Tambah Jadwal
                </a>
                <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-round d-none ms-2">
                    <i class="fa fa-trash"></i> Hapus Terpilih
                </button>
            </div>

            <!-- Filter Section -->
            <div class="row my-4 g-3">
                {{-- ? filter input select kelas --}}
                <div class="col-md-2">
                    <label class="form-label font-weight-bold text-secondary fs-8">Kelas</label>
                    <select id="filter-kelas" class="form-select select-filter">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- ? filter input select rombel  --}}
                <div class="col-md-2">
                    <label class="form-label font-weight-bold text-secondary fs-8">Rombel</label>
                    <select id="filter-rombel" class="form-select select-filter">
                        <option value="">Semua Rombel</option>
                        @foreach ($rombelList as $r)
                            <option value="{{ $r->id }}">{{ $r->nama }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- ? filter input select semester  --}}
                <div class="col-md-2">
                    <label class="form-label font-weight-bold text-secondary fs-8">Semester</label>
                    <select id="filter-semester" class="form-select select-filter">
                        <option value="">Semua Semester</option>
                        @foreach ($semesterList as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- ? filter input select hari  --}}
                <div class="col-md-2">
                    <label class="form-label font-weight-bold text-secondary fs-8">Hari</label>
                    <select id="filter-hari" class="form-select select-filter">
                        <option value="">Semua Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                {{-- ? filter input select jam mulai --}}
                <div class="col-md-2">
                    <label class="form-label font-weight-bold text-secondary fs-8">Jam Mulai</label>
                    <select id="filter-jam" class="form-select select-filter">
                        <option value="">Semua Waktu</option>
                        @foreach (['06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00'] as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- ? filter input select jam selesai --}}
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="btn-reset-filter" class="btn btn-secondary w-100 btn-round">
                        <i class="fa fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>

            <form id="bulk-delete-form" action="{{ route('dashboard.jadwal-pelajaran.bulk-destroy') }}" method="POST"
                style="display: none;">
                @csrf
                <div id="bulk-delete-inputs"></div>
            </form>

            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover mt-4 w-100'], true) !!}
            </div>
        </div>
    </div>

    <x-slot:myScript>
        {{-- ? sweatalert 2 lib --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- ? toastify library  --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <!-- DataTables & Full Export Extensions JS -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

        <!-- FullCalendar 6 Script -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

        {!! $dataTable->scripts() !!}

        <script>
            jQuery(function($) {
                // Initialize FullCalendar Roster
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    locale: 'id',
                    firstDay: 1, // Monday
                    allDaySlot: false,
                    slotMinTime: '06:30:00',
                    slotMaxTime: '16:00:00',
                    slotDuration: '00:30:00',
                    expandRows: true,
                    headerToolbar: false, // Hide headers (prev/next/today) since it is a static weekly roster
                    dayHeaderFormat: {
                        weekday: 'long'
                    },
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false,
                        hour12: false
                    },
                    events: '{{ route('dashboard.jadwal-pelajaran.events') }}',
                    eventClick: function(info) {
                        var props = info.event.extendedProps;
                        Swal.fire({
                            title: '<i class="fa fa-calendar-check text-primary me-2"></i> Detail Roster Kelas',
                            html: `
                                <div class="row g-2 mt-1">
                                    <!-- Mata Pelajaran -->
                                    <div class="col-12">
                                        <div class="detail-card">
                                            <div class="detail-icon"><i class="fa fa-book"></i></div>
                                            <div class="detail-content">
                                                <div class="detail-label">Mata Pelajaran</div>
                                                <div class="detail-value wrap">${props.mataPelajaran}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Guru Pengampu -->
                                    <div class="col-12">
                                        <div class="detail-card">
                                            <div class="detail-icon"><i class="fa fa-user-tie"></i></div>
                                            <div class="detail-content">
                                                <div class="detail-label">Guru Pengampu</div>
                                                <div class="detail-value wrap">${props.guru}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Kelas & Rombel -->
                                    <div class="col-6">
                                        <div class="detail-card h-100">
                                            <div class="detail-icon"><i class="fa fa-graduation-cap"></i></div>
                                            <div class="detail-content">
                                                <div class="detail-label">Kelas & Rombel</div>
                                                <div class="detail-value"><span class="detail-badge">${props.kelas} (${props.rombel})</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Semester -->
                                    <div class="col-6">
                                        <div class="detail-card h-100">
                                            <div class="detail-icon"><i class="fa fa-calendar-alt"></i></div>
                                            <div class="detail-content">
                                                <div class="detail-label">Semester</div>
                                                <div class="detail-value"><span class="detail-badge bg-light text-secondary">${props.semester} (${props.ganjilGenap})</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hari / Waktu -->
                                    <div class="col-12 mt-2">
                                        <div class="detail-card">
                                            <div class="detail-icon"><i class="fa fa-clock"></i></div>
                                            <div class="detail-content">
                                                <div class="detail-label">Hari / Waktu</div>
                                                <div class="detail-value text-primary">${props.hari}, ${props.waktu}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Ruangan -->
                                    <div class="col-12">
                                        <div class="detail-card">
                                            <div class="detail-icon"><i class="fa fa-door-open"></i></div>
                                            <div class="detail-content">
                                                <div class="detail-label">Ruangan</div>
                                                <div class="detail-value">${props.ruangan || '-'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `,
                            confirmButtonText: 'Tutup',
                            customClass: {
                                popup: 'swal2-premium-modal',
                                confirmButton: 'btn btn-primary btn-round px-4'
                            },
                            buttonsStyling: false
                        });
                    }
                });
                calendar.render();

                // Toggle select all checkbox
                $(document).on('click', '#select-all', function() {
                    $('.row-checkbox').prop('checked', this.checked);
                    toggleBulkDeleteButton();
                });

                // Toggle individual row checkbox
                $(document).on('change', '.row-checkbox', function() {
                    if (!this.checked) {
                        $('#select-all').prop('checked', false);
                    } else {
                        var allChecked = $('.row-checkbox').length === $('.row-checkbox:checked').length;
                        $('#select-all').prop('checked', allChecked);
                    }
                    toggleBulkDeleteButton();
                });

                // Retrieve the DataTable instance
                var tableId = 'jadwalpelajaran-table';
                var table = window.LaravelDataTables && window.LaravelDataTables[tableId];

                if (table) {
                    // Reset select all checkbox on DataTable redraw
                    table.on('draw', function() {
                        $('#select-all').prop('checked', false);
                        toggleBulkDeleteButton();
                    });

                    // Add dynamic parameters to AJAX request
                    table.on('preXhr.dt', function(e, settings, data) {
                        data.kelas_id = $('#filter-kelas').val();
                        data.rombel_id = $('#filter-rombel').val();
                        data.semester_id = $('#filter-semester').val();
                        data.hari = $('#filter-hari').val();
                        data.jam_mulai = $('#filter-jam').val();
                    });

                    // Trigger reload when filters change
                    $('.select-filter').on('change', function() {
                        table.ajax.reload();
                    });

                    // Handle Reset Filter button
                    $('#btn-reset-filter').on('click', function() {
                        $('.select-filter').val('');
                        table.ajax.reload();
                    });
                }

                function toggleBulkDeleteButton() {
                    var checkedCount = $('.row-checkbox:checked').length;
                    if (checkedCount > 0) {
                        $('#btn-bulk-delete').removeClass('d-none');
                    } else {
                        $('#btn-bulk-delete').addClass('d-none');
                    }
                }

                // Handle Bulk Delete Submit
                $('#btn-bulk-delete').on('click', function(e) {
                    e.preventDefault();

                    var checkedCheckboxes = $('.row-checkbox:checked');
                    var count = checkedCheckboxes.length;

                    if (count === 0) return;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menghapus " + count +
                            " jadwal pelajaran terpilih secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'btn btn-danger mx-2 btn-round',
                            cancelButton: 'btn btn-secondary mx-2 btn-round'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var inputs = '';
                            checkedCheckboxes.each(function() {
                                inputs += '<input type="hidden" name="ids[]" value="' + $(this)
                                    .val() + '">';
                            });

                            $('#bulk-delete-inputs').html(inputs);
                            $('#bulk-delete-form').submit();
                        }
                    });
                });

                // Handle Single Row Delete with SweetAlert2
                $(document).on('click', '.btn-delete-row', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Jadwal pelajaran ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'btn btn-danger mx-2 btn-round',
                            cancelButton: 'btn btn-secondary mx-2 btn-round'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                // Handle Single Row Show Detail with SweetAlert2 & AJAX
                $(document).on('click', '.btn-show-row', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var url = '{{ route('dashboard.jadwal-pelajaran.show', ':id') }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire({
                                title: '<i class="fa fa-info-circle text-primary me-2"></i> Detail Jadwal Pelajaran',
                                html: `
                                    <div class="row g-2 mt-1">
                                        <!-- Mata Pelajaran -->
                                        <div class="col-12">
                                            <div class="detail-card">
                                                <div class="detail-icon"><i class="fa fa-book"></i></div>
                                                <div class="detail-content">
                                                    <div class="detail-label">Mata Pelajaran</div>
                                                    <div class="detail-value wrap">${data.mata_pelajaran ? data.mata_pelajaran.nama : '-'}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Guru Pengampu -->
                                        <div class="col-12">
                                            <div class="detail-card">
                                                <div class="detail-icon"><i class="fa fa-user-tie"></i></div>
                                                <div class="detail-content">
                                                    <div class="detail-label">Guru Pengampu</div>
                                                    <div class="detail-value wrap">${data.guru ? data.guru.nama_lengkap : '-'}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Kelas & Rombel -->
                                        <div class="col-6">
                                            <div class="detail-card h-100">
                                                <div class="detail-icon"><i class="fa fa-graduation-cap"></i></div>
                                                <div class="detail-content">
                                                    <div class="detail-label">Kelas & Rombel</div>
                                                    <div class="detail-value"><span class="detail-badge">${data.kelas ? data.kelas.nama : '-'} (${data.rombel ? data.rombel.nama : '-'})</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Semester -->
                                        <div class="col-6">
                                            <div class="detail-card h-100">
                                                <div class="detail-icon"><i class="fa fa-calendar-alt"></i></div>
                                                <div class="detail-content">
                                                    <div class="detail-label">Semester</div>
                                                    <div class="detail-value"><span class="detail-badge bg-light text-secondary">${data.semester ? data.semester.nama : '-'} (${data.ganjil_genap})</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Hari / Waktu -->
                                        <div class="col-12 mt-2">
                                            <div class="detail-card">
                                                <div class="detail-icon"><i class="fa fa-clock"></i></div>
                                                <div class="detail-content">
                                                    <div class="detail-label">Hari / Waktu</div>
                                                    <div class="detail-value text-primary">${data.hari}, ${data.jam_mulai.substring(0,5)} - ${data.jam_selesai.substring(0,5)}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ruangan -->
                                        <div class="col-12">
                                            <div class="detail-card">
                                                <div class="detail-icon"><i class="fa fa-door-open"></i></div>
                                                <div class="detail-content">
                                                    <div class="detail-label">Ruangan</div>
                                                    <div class="detail-value">${data.ruangan || '-'}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `,
                                confirmButtonText: 'Tutup',
                                customClass: {
                                    popup: 'swal2-premium-modal',
                                    confirmButton: 'btn btn-primary btn-round px-4'
                                },
                                buttonsStyling: false
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'Gagal memuat data detail jadwal pelajaran.',
                                icon: 'error',
                                confirmButtonText: 'Tutup'
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
