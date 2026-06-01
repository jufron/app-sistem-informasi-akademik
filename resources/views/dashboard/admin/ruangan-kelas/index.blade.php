<x-dashboard.layoutDashboard.app title="Ruangan Kelas">
    <x-slot:myStyle>
        {{-- ? sweetalert 2 lib --}}
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

        {{-- ? toastify css  --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- DataTables & Buttons Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

        <!-- Custom Premium Checkbox and Filter Styling -->
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

            .filter-card {
                background: #fdfdfd;
                border: 1px solid #ebedf2;
                border-radius: 8px;
                padding: 20px;
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Ruangan Kelas (Rombongan Kelas)</h4>
        </div>
        <div class="card-body">

            <!-- Filters Section -->
            <div class="filter-card p-3 mb-4">
                <h6 class="font-weight-bold text-secondary mb-3"><i class="fa fa-filter me-2"></i> Filter Data</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="filter-kelas" class="form-label font-weight-bold text-dark">Kelas</label>
                        <select id="filter-kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-rombel" class="form-label font-weight-bold text-dark">Rombongan
                            Belajar</label>
                        <select id="filter-rombel" class="form-select">
                            <option value="">Semua Rombongan</option>
                            @foreach ($rombel as $r)
                                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-semester" class="form-label font-weight-bold text-dark">Semester</label>
                        <select id="filter-semester" class="form-select">
                            <option value="">Semua Semester</option>
                            @foreach ($semester as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="my-4 d-flex align-items-center justify-content-between">
                <div>
                    <a href="{{ route('dashboard.ruangan-kelas.create') }}" class="btn btn-primary btn-round">
                        <i class="fa fa-plus"></i> Tambah Ruangan
                    </a>
                    <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-round d-none ms-2">
                        <i class="fa fa-trash"></i> Hapus Terpilih
                    </button>
                </div>
            </div>

            <form id="bulk-delete-form" action="{{ route('dashboard.ruangan-kelas.bulk-destroy') }}" method="POST"
                style="display: none;">
                @csrf
                <div id="bulk-delete-inputs"></div>
            </form>

            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover mt-4 w-100'], true) !!}
            </div>

            <!-- Modal Detail Ruangan Kelas -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                        <div class="modal-header text-white py-3 border-0"
                            style="background: linear-gradient(135deg, #1572e8 0%, #064fa9 100%);">
                            <h5 class="modal-title font-weight-bold" id="modalDetailLabel">
                                <i class="fas fa-graduation-cap me-2"></i> Informasi Rombongan Belajar
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4" style="background-color: #f6f8fb;">

                            <!-- Top Section: Modern 4-Column Grid Cards -->
                            <div class="row g-3 mb-4">
                                <!-- Card 1: Kelas & Rombel -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 border-0 shadow-sm rounded-4 text-center h-100 bg-white"
                                        style="border-radius: 14px;">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                            style="width: 48px; height: 48px; background-color: rgba(21, 114, 232, 0.1);">
                                            <i class="fas fa-school text-primary fa-lg"></i>
                                        </div>
                                        <div class="text-secondary font-weight-bold mb-1"
                                            style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Kelas & Rombel</div>
                                        <div class="font-weight-bold text-dark" id="detail-kelas-rombel"
                                            style="font-size: 1.1rem; line-height: 1.2;">-</div>
                                    </div>
                                </div>
                                <!-- Card 2: Wali Kelas -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 border-0 shadow-sm rounded-4 text-center h-100 bg-white"
                                        style="border-radius: 14px;">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                            style="width: 48px; height: 48px; background-color: rgba(40, 167, 69, 0.1);">
                                            <i class="fas fa-chalkboard-teacher text-success fa-lg"></i>
                                        </div>
                                        <div class="text-secondary font-weight-bold mb-1"
                                            style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Wali Kelas</div>
                                        <div class="font-weight-bold text-dark" id="detail-guru"
                                            style="font-size: 1rem; line-height: 1.2;">-</div>
                                    </div>
                                </div>
                                <!-- Card 3: Akademik -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 border-0 shadow-sm rounded-4 text-center h-100 bg-white"
                                        style="border-radius: 14px;">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                            style="width: 48px; height: 48px; background-color: rgba(255, 193, 7, 0.15);">
                                            <i class="fas fa-calendar-alt text-warning fa-lg"></i>
                                        </div>
                                        <div class="text-secondary font-weight-bold mb-1"
                                            style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Tahun Ajaran & Semester</div>
                                        <div class="font-weight-bold text-dark" id="detail-ajaran-semester"
                                            style="font-size: 0.95rem; line-height: 1.2;">-</div>
                                    </div>
                                </div>
                                <!-- Card 4: Kapasitas & Status -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="p-3 border-0 shadow-sm rounded-4 text-center h-100 bg-white"
                                        style="border-radius: 14px;">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                                            style="width: 48px; height: 48px; background-color: rgba(23, 162, 184, 0.1);">
                                            <i class="fas fa-users text-info fa-lg"></i>
                                        </div>
                                        <div class="text-secondary font-weight-bold mb-1"
                                            style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Status & Total Siswa</div>
                                        <div class="d-flex align-items-center justify-content-center gap-2 mt-1">
                                            <span id="detail-status">-</span>
                                            <span class="badge bg-primary px-2.5 py-1.5 rounded-pill font-weight-bold"
                                                id="detail-total-siswa" style="font-size: 0.75rem;">0 Siswa</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Section: Minimalist Horizontal Info Strip -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center bg-white px-4 py-3 shadow-sm mb-4"
                                style="border-radius: 12px; font-size: 0.85rem;">
                                <div class="text-secondary d-flex align-items-center">
                                    <i class="fas fa-calendar-check me-2 text-primary fa-lg"></i>
                                    <span><strong>Tahun Angkatan:</strong> <span id="detail-angkatan"
                                            class="text-dark font-weight-bold ms-1">-</span></span>
                                </div>
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="text-secondary d-flex align-items-center">
                                        <i class="fas fa-clock me-2 text-muted"></i>
                                        <span><strong>Dibuat:</strong> <span id="detail-created"
                                                class="text-dark ms-1">-</span></span>
                                    </div>
                                    <div class="text-secondary d-flex align-items-center">
                                        <i class="fas fa-history me-2 text-muted"></i>
                                        <span><strong>Terakhir Diubah:</strong> <span id="detail-updated"
                                                class="text-dark ms-1">-</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Section: Full-Width Table Card -->
                            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                                <div
                                    class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <h6 class="card-title text-primary font-weight-bold m-0" style="font-size: 1rem;">
                                        <i class="fas fa-users-cog me-2"></i> Daftar Anggota Rombongan Belajar (Siswa)
                                    </h6>
                                    <div class="position-relative">
                                        <input type="text" id="search-siswa-modal"
                                            class="form-control form-control-sm"
                                            placeholder="Cari nama atau NIS siswa..."
                                            style="width: 260px; border-radius: 20px; padding-left: 35px; height: 36px; border: 1px solid #ced4da;">
                                        <span class="position-absolute text-muted"
                                            style="left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                                        <table class="table table-hover table-striped align-middle m-0"
                                            id="table-siswa-modal" style="font-size: 0.9rem;">
                                            <thead class="table-light sticky-top"
                                                style="z-index: 1; border-top: 1px solid #ebedf2;">
                                                <tr>
                                                    <th class="ps-4 py-3" style="width: 6%;">No</th>
                                                    <th style="width: 35%;">Data Lengkap Siswa</th>
                                                    <th style="width: 15%;">Tanggal Masuk</th>
                                                    <th style="width: 15%;">Tanggal Keluar</th>
                                                    <th style="width: 15%;">Status</th>
                                                    <th class="pe-4" style="width: 14%;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail-siswa-rows">
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="fas fa-info-circle me-1"></i> Tidak ada data siswa di
                                                        ruangan kelas ini
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer bg-white border-0 py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; border-top: 1px solid #f1f2f5;">
                            <a href="#" id="btn-download-pdf" class="btn btn-danger btn-round px-4 me-auto">
                                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                            </a>
                            <button type="button" class="btn btn-secondary btn-round px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
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

        {!! $dataTable->scripts() !!}

        <script>
            jQuery(function($) {
                var tableId = 'ruangankelas-table';
                var table = null;

                // Hook filters into DataTable ajax parameters
                $(document).ready(function() {
                    table = window.LaravelDataTables && window.LaravelDataTables[tableId];
                    if (table) {
                        table.on('preXhr.dt', function(e, settings, data) {
                            data.kelas_id = $('#filter-kelas').val();
                            data.rombel_id = $('#filter-rombel').val();
                            data.semester_id = $('#filter-semester').val();
                        });

                        // Reset select all checkbox on DataTable redraw
                        table.on('draw', function() {
                            $('#select-all').prop('checked', false);
                            toggleBulkDeleteButton();
                        });
                    }
                });

                // Trigger redraw when any filter dropdown value changes
                $('#filter-kelas, #filter-rombel, #filter-semester').on('change', function() {
                    if (table) {
                        table.draw();
                    }
                });

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
                            " data ruangan kelas terpilih secara permanen!",
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
                        text: "Data ruangan kelas ini akan dihapus secara permanen!",
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

                // Handle click on "Lihat Detail" button
                $(document).on('click', '.btn-show-detail', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var kelasNama = data.kelas ? data.kelas.nama : '-';
                            var rombelNama = data.rombel ? data.rombel.nama : '-';
                            $('#detail-kelas-rombel').text(kelasNama + ' - ' + rombelNama);
                            $('#detail-guru').text(data.guru ? data.guru.nama_lengkap : '-');

                            var semesterNama = data.semester ? data.semester.nama : '-';
                            var ajaranNama = data.tahun_ajaran || '-';
                            $('#detail-ajaran-semester').text(ajaranNama + ' (' + semesterNama +
                                ')');

                            var statusBadge = data.aktif ?
                                '<span class="badge bg-success px-3 py-1 rounded-pill">Aktif</span>' :
                                '<span class="badge bg-danger px-3 py-1 rounded-pill">Tidak Aktif</span>';
                            $('#detail-status').html(statusBadge);

                            var parseDate = function(dateStr) {
                                if (!dateStr) return '-';
                                var parsed = new Date(dateStr);
                                return isNaN(parsed.getTime()) ? dateStr : parsed
                                    .toLocaleString('id-ID', {
                                        dateStyle: 'long',
                                        timeStyle: 'short'
                                    });
                            };

                            var parseSimpleDate = function(dateStr) {
                                if (!dateStr) return '-';
                                var parsed = new Date(dateStr);
                                return isNaN(parsed.getTime()) ? dateStr : parsed
                                    .toLocaleDateString('id-ID', {
                                        dateStyle: 'medium'
                                    });
                            };

                            $('#detail-angkatan').text(data.tahun_angkatan || '-');
                            $('#detail-created').text(parseDate(data.created_at));
                            $('#detail-updated').text(parseDate(data.updated_at));

                            // Load and populate enrolled students
                            var anggotaList = data.anggota_kelas || data.anggotaKelas || [];
                            $('#detail-total-siswa').text(anggotaList.length + ' Siswa');

                            var rows = '';
                            if (anggotaList.length > 0) {
                                $.each(anggotaList, function(index, member) {
                                    var name = '-';
                                    var nisn = '-';
                                    var nis = '-';
                                    if (member.siswa) {
                                        name = member.siswa.nama_lengkap || '-';
                                        nisn = member.siswa.nisn || '-';
                                        nis = member.siswa.nis || '-';
                                    }

                                    var status = member.status || 'Aktif';
                                    var badgeClass = 'bg-secondary';
                                    if (status === 'Aktif') badgeClass = 'bg-success';
                                    else if (status === 'Naik Kelas' || status === 'Lulus')
                                        badgeClass = 'bg-info';
                                    else if (status === 'Tinggal Kelas') badgeClass =
                                        'bg-warning text-dark';
                                    else if (status === 'Mutasi Keluar' || status ===
                                        'Keluar') badgeClass = 'bg-danger';
                                    else if (status === 'Mutasi Masuk') badgeClass =
                                        'bg-primary';

                                    var tglMasuk = parseSimpleDate(member.tanggal_masuk);
                                    var tglKeluar = parseSimpleDate(member.tanggal_keluar);
                                    var keterangan = member.keterangan || '-';

                                    rows += '<tr class="student-row">';
                                    rows +=
                                        '<td class="ps-4 text-secondary font-weight-bold">' +
                                        (index + 1) + '</td>';
                                    rows += '<td>';
                                    rows +=
                                        '  <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">' +
                                        name + '</div>';
                                    rows +=
                                        '  <div class="text-muted" style="font-size: 0.8rem;">NISN: ' +
                                        nisn + ' | NIS: ' + nis + '</div>';
                                    rows += '</td>';
                                    rows += '<td>' + tglMasuk + '</td>';
                                    rows += '<td>' + tglKeluar + '</td>';
                                    rows += '<td><span class="badge ' + badgeClass +
                                        ' px-2.5 py-1.5 rounded-pill" style="font-size: 0.75rem; font-weight: 600;">' +
                                        status + '</span></td>';
                                    rows +=
                                        '<td class="pe-4 text-secondary" style="font-size: 0.85rem; font-style: italic;">' +
                                        keterangan + '</td>';
                                    rows += '</tr>';
                                });
                            } else {
                                rows =
                                    '<tr><td colspan="6" class="text-center text-muted py-5"><i class="fas fa-info-circle me-1"></i> Tidak ada data siswa di ruangan kelas ini</td></tr>';
                            }

                            $('#detail-siswa-rows').html(rows);
                            $('#search-siswa-modal').val(''); // Reset search text
                            
                            var pdfUrl = '{{ route("dashboard.ruangan-kelas.pdf", ":id") }}'.replace(':id', data.id);
                            $('#btn-download-pdf').attr('href', pdfUrl);

                            $('#modalDetail').modal('show');
                        },
                        error: function(xhr) {
                            Toastify({
                                text: "Gagal mengambil data detail ruangan kelas",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast();
                        }
                    });
                });

                // Client-side search for students in the modal
                $(document).on('keyup', '#search-siswa-modal', function() {
                    var value = $(this).val().toLowerCase();
                    $("#detail-siswa-rows tr.student-row").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
