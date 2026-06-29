<x-dashboard.layoutDashboard.app title="Siswa">
    <x-slot:myStyle>
        {{-- ? sweetalert 2 lib --}}
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

        {{-- ? toastify css  --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- DataTables & Buttons Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

        <!-- Custom Premium Checkbox & Detail Styling -->
        <style>
            .row-checkbox, #select-all {
                width: 1.3rem !important;
                height: 1.3rem !important;
                cursor: pointer;
                border: 2px solid #ced4da !important;
                border-radius: 4px !important;
                transition: all 0.2s ease-in-out;
                vertical-align: middle;
            }
            .row-checkbox:hover, #select-all:hover {
                border-color: #1572e8 !important;
                box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
            }
            .row-checkbox:checked, #select-all:checked {
                background-color: #1572e8 !important;
                border-color: #1572e8 !important;
                transform: scale(1.1);
            }
            .avatar-detail {
                width: 110px;
                height: 110px;
                object-fit: cover;
                border-radius: 50%;
                border: 3px solid #1572e8;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Siswa</h4>
        </div>
        <div class="card-body">
            <div class="my-4">
                <a href="{{ route('dashboard.siswa.create') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i> Tambah Siswa
                </a>
                <button type="button" class="btn btn-info btn-round ms-2" data-bs-toggle="modal" data-bs-target="#modalImport">
                    <i class="fa fa-file-import"></i> Import CSV
                </button>
                <a href="{{ route('dashboard.siswa.template') }}" class="btn btn-secondary btn-round ms-2">
                    <i class="fa fa-file-download"></i> Template CSV
                </a>
                <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-round d-none ms-2">
                    <i class="fa fa-trash"></i> Hapus Terpilih
                </button>
            </div>

            <form id="bulk-delete-form" action="{{ route('dashboard.siswa.bulk-destroy') }}" method="POST" style="display: none;">
                @csrf
                <div id="bulk-delete-inputs"></div>
            </form>

            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover mt-4 w-100'], true) !!}
            </div>

            <!-- Modal Import Siswa -->
            <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header bg-info text-white" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            <h5 class="modal-title font-weight-bold" id="modalImportLabel">
                                <i class="fa fa-file-import me-2"></i> Import Massal Data Siswa
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('dashboard.siswa.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4" style="background-color: rgba(23, 162, 184, 0.1); color: #117a8b;">
                                    <h6 class="font-weight-bold mb-2"><i class="fa fa-info-circle me-2"></i> Petunjuk & Aturan Import:</h6>
                                    <ul class="m-0 ps-3 fs-7" style="line-height: 1.6;">
                                        <li>Unduh terlebih dahulu <strong><a href="{{ route('dashboard.siswa.template') }}" class="text-decoration-underline" style="color: #117a8b;">Template CSV Standar</a></strong> agar format data sesuai.</li>
                                        <li>Kolom berikut <strong>wajib diisi</strong>: <code>Email</code>, <code>Nama Lengkap</code>, <code>Jenis Kelamin</code>, <code>Agama</code>, <code>Tempat Lahir</code>, <code>Tanggal Lahir</code> (Format: YYYY-MM-DD), <code>Alamat</code>.</li>
                                        <li>Kolom <code>Password</code> bersifat opsional, jika dikosongkan sistem otomatis mengisi dengan default <code>12345678</code>.</li>
                                        <li>Kolom <code>NISN</code> dan <code>NIS</code> bersifat opsional, namun jika diisi harus bersifat unik (belum terdaftar).</li>
                                        <li>Lookup <code>Jenis Kelamin</code> dan <code>Agama</code> harus persis sesuai yang ada di database. Jika tidak sesuai, baris tersebut akan **otomatis di-skip**.</li>
                                        <li>Kolom <code>Foto</code> dilewati dan tidak akan di-import (bernilai null).</li>
                                        <li>Setiap baris kosong atau memiliki data wajib yang kosong akan <strong>otomatis dilewati (di-skip)</strong>.</li>
                                    </ul>
                                </div>

                                <div class="mb-3">
                                    <label for="csv_file" class="form-label font-weight-bold text-dark">Pilih File CSV / TXT</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fa fa-file-csv text-info fs-4"></i></span>
                                        <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv, text/plain" required>
                                    </div>
                                    <small class="text-muted d-block mt-1">Hanya mendukung format file .csv atau .txt (Maksimal 2MB).</small>
                                </div>
                            </div>
                            <div class="modal-footer bg-light border-0" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                                <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-info btn-round">
                                    <i class="fa fa-upload me-1"></i> Mulai Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Siswa -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header bg-primary text-white" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            <h5 class="modal-title font-weight-bold" id="modalDetailLabel">
                                <i class="fa fa-info-circle me-2"></i> Profil Lengkap Siswa
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <img id="detail-foto" src="" alt="Foto Siswa" class="avatar-detail">
                                </div>
                                <div class="col-md-9 text-center text-md-start">
                                    <h3 id="detail-nama" class="font-weight-bold text-dark m-0">-</h3>
                                    <p id="detail-nisn-nis-sub" class="text-secondary m-0">NISN / NIS: -</p>
                                    <div class="mt-2">
                                        <span id="detail-badge-status" class="badge">-</span>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="text-muted">

                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless m-0">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold text-secondary" style="width: 40%;">Nama Lengkap</td>
                                                <td style="width: 5%;">:</td>
                                                <td id="detail-nama-lengkap" class="text-dark font-weight-bold">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold text-secondary">Nama Panggilan</td>
                                                <td>:</td>
                                                <td id="detail-nama-panggilan" class="text-dark">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold text-secondary">Email Account</td>
                                                <td>:</td>
                                                <td id="detail-email" class="text-dark font-weight-bold">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold text-secondary">Jenis Kelamin</td>
                                                <td>:</td>
                                                <td id="detail-jk" class="text-dark">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold text-secondary">Agama</td>
                                                <td>:</td>
                                                <td id="detail-agama" class="text-dark">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless m-0">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold text-secondary" style="width: 40%;">Lahir</td>
                                                <td style="width: 5%;">:</td>
                                                <td id="detail-lahir" class="text-dark">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold text-secondary">Telepon</td>
                                                <td>:</td>
                                                <td id="detail-telepon" class="text-dark">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold text-secondary">Alamat</td>
                                                <td>:</td>
                                                <td id="detail-alamat" class="text-dark" style="white-space: pre-line;">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                            <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <x-slot:myScript>
        {{-- ? sweetalert 2 lib --}}
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
                var tableId = 'siswa-table';
                var table = window.LaravelDataTables && window.LaravelDataTables[tableId];

                if (table) {
                    // Reset select all checkbox on DataTable redraw
                    table.on('draw', function() {
                        $('#select-all').prop('checked', false);
                        toggleBulkDeleteButton();
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
                        text: "Anda akan menghapus " + count + " data siswa terpilih secara permanen beserta akun user mereka!",
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
                                inputs += '<input type="hidden" name="ids[]" value="' + $(this).val() + '">';
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
                        text: "Data profil siswa ini dan akun user-nya akan dihapus secara permanen!",
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
                            // Basic attributes
                            $('#detail-nama').text(data.nama_lengkap);
                            var nisn = data.nisn || '-';
                            var nis = data.nis || '-';
                            $('#detail-nisn-nis-sub').text('NISN. ' + nisn + ' / NIS. ' + nis);
                            $('#detail-nama-lengkap').text(data.nama_lengkap);
                            $('#detail-nama-panggilan').text(data.nama_panggilan || '-');
                            $('#detail-email').text(data.user ? data.user.email : '-');
                            $('#detail-jk').text(data.jenis_kelamin ? data.jenis_kelamin.nama : '-');
                            $('#detail-agama').text(data.agama ? data.agama.nama : '-');
                            $('#detail-lahir').text(data.tempat_lahir + ', ' + data.tanggal_lahir);
                            $('#detail-telepon').text(data.telepon || '-');
                            $('#detail-alamat').text(data.alamat);

                            // Badges status
                            var badgeStatus = $('#detail-badge-status');
                            badgeStatus.removeClass('bg-success bg-warning text-dark bg-danger');
                            if (data.status === 'Aktif') {
                                badgeStatus.addClass('bg-success').text('Aktif');
                            } else if (data.status === 'Cuti') {
                                badgeStatus.addClass('bg-warning text-dark').text('Cuti');
                            } else {
                                badgeStatus.addClass('bg-danger').text('Nonaktif');
                            }

                            // Set photo
                            var fotoElement = $('#detail-foto');
                            if (data.foto) {
                                fotoElement.attr('src', '/storage/' + data.foto);
                            } else {
                                // Gravatar hash
                                var emailHash = data.user && data.user.email ? data.user.email.trim().toLowerCase() : 'default';
                                fotoElement.attr('src', 'https://www.gravatar.com/avatar/' + emailHash + '?d=mp&s=150');
                            }

                            // Show the modal
                            $('#modalDetail').modal('show');
                        },
                        error: function(xhr) {
                            Toastify({
                                text: "Gagal mengambil detail profil siswa",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast();
                        }
                    });
                });
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
