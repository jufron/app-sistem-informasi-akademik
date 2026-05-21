<x-dashboard.layoutDashboard.app title="Guru">
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
            .subject-badge {
                display: inline-block;
                background: linear-gradient(135deg, #1572e8, #48abf7);
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                margin: 2px;
                box-shadow: 0 2px 6px rgba(21, 114, 232, 0.15);
            }
        </style>
    </x-slot:myStyle>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Guru & Tenaga Pengajar</h4>
        </div>
        <div class="card-body">
            <div class="my-4">
                <a href="{{ route('dashboard.guru.create') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i> Tambah Guru
                </a>
                <button type="button" class="btn btn-info btn-round ms-2" data-bs-toggle="modal" data-bs-target="#modalImport">
                    <i class="fa fa-file-import"></i> Import CSV
                </button>
                <a href="{{ route('dashboard.guru.template') }}" class="btn btn-secondary btn-round ms-2">
                    <i class="fa fa-file-download"></i> Template CSV
                </a>
                <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-round d-none ms-2">
                    <i class="fa fa-trash"></i> Hapus Terpilih
                </button>
            </div>


            <form id="bulk-delete-form" action="{{ route('dashboard.guru.bulk-destroy') }}" method="POST" style="display: none;">
                @csrf
                <div id="bulk-delete-inputs"></div>
            </form>

            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover mt-4 w-100'], true) !!}
            </div>

            <!-- Modal Import Guru -->
            <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header bg-info text-white" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            <h5 class="modal-title font-weight-bold" id="modalImportLabel">
                                <i class="fa fa-file-import me-2"></i> Import Massal Data Guru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('dashboard.guru.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4" style="background-color: rgba(23, 162, 184, 0.1); color: #117a8b;">
                                    <h6 class="font-weight-bold mb-2"><i class="fa fa-info-circle me-2"></i> Petunjuk & Aturan Import:</h6>
                                    <ul class="m-0 ps-3 fs-7" style="line-height: 1.6;">
                                        <li>Unduh terlebih dahulu <strong><a href="{{ route('dashboard.guru.template') }}" class="text-decoration-underline" style="color: #117a8b;">Template CSV Standar</a></strong> agar format data sesuai.</li>
                                        <li>Kolom berikut <strong>wajib diisi</strong>: <code>Email</code>, <code>Nama Lengkap</code>, <code>Jenis Kelamin</code>, <code>Agama</code>, <code>Tempat Lahir</code>, <code>Tanggal Lahir</code> (Format: YYYY-MM-DD), <code>Telepon</code>, <code>Alamat</code>, <code>Tipe Jabatan</code>.</li>
                                        <li>Kolom <code>NIP</code> bersifat <strong>opsional</strong>, namun jika diisi harus bersifat unik (belum terdaftar).</li>
                                        <li>Kolom <code>Tipe Jabatan</code> harus berisi salah satu dari: <code>Bukan Wali Kelas</code>, <code>Wali Kelas</code>, atau <code>Kepala Sekolah</code>.</li>
                                        <li>Sistem membatasi maksimal hanya ada <strong>1 Kepala Sekolah</strong>. Baris tambahan Kepala Sekolah akan di-skip.</li>
                                        <li>Lookup <code>Jenis Kelamin</code>, <code>Agama</code>, dan <code>Mata Pelajaran</code> harus persis sesuai yang ada di database. Jika tidak sesuai, baris tersebut akan **otomatis di-skip**.</li>
                                        <li>Pisahkan beberapa <code>Mata Pelajaran</code> dengan tanda koma (e.g. <code>Matematika, Bahasa Inggris</code>).</li>
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

            <!-- Modal Detail Guru -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header bg-primary text-white" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            <h5 class="modal-title font-weight-bold" id="modalDetailLabel">
                                <i class="fa fa-info-circle me-2"></i> Profil Lengkap Guru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <img id="detail-foto" src="" alt="Foto Guru" class="avatar-detail">
                                </div>
                                <div class="col-md-9 text-center text-md-start">
                                    <h3 id="detail-nama" class="font-weight-bold text-dark m-0">-</h3>
                                    <p id="detail-nip-sub" class="text-secondary m-0">NIP. -</p>
                                    <div class="mt-2">
                                        <span id="detail-badge-jabatan" class="badge me-1">-</span>
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

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded-3">
                                        <h6 class="font-weight-bold text-secondary mb-2"><i class="fa fa-book me-2"></i> Mengampu Mata Pelajaran:</h6>
                                        <div id="detail-subjects-container" class="d-flex flex-wrap align-items-center">
                                            <!-- Subjects dynamic badges here -->
                                        </div>
                                    </div>
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
                var tableId = 'guru-table';
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
                        text: "Anda akan menghapus " + count + " data guru terpilih secara permanen beserta akun user mereka!",
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
                        text: "Data profil guru ini dan akun user-nya akan dihapus secara permanen!",
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
                            $('#detail-nip-sub').text('NIP. ' + data.nip);
                            $('#detail-nama-lengkap').text(data.nama_lengkap);
                            $('#detail-nama-panggilan').text(data.nama_panggilan || '-');
                            $('#detail-email').text(data.user ? data.user.email : '-');
                            $('#detail-jk').text(data.jenis_kelamin ? data.jenis_kelamin.nama : '-');
                            $('#detail-agama').text(data.agama ? data.agama.nama : '-');
                            $('#detail-lahir').text(data.tempat_lahir + ', ' + data.tanggal_lahir);
                            $('#detail-telepon').text(data.telepon);
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

                            // Badges jabatan
                            var badgeJabatan = $('#detail-badge-jabatan');
                            badgeJabatan.removeClass('bg-danger bg-success bg-secondary');
                            if (data.tipe === 'Kepala Sekolah') {
                                badgeJabatan.addClass('bg-danger').text('Kepala Sekolah');
                            } else if (data.tipe === 'Wali Kelas') {
                                badgeJabatan.addClass('bg-success').text('Wali Kelas');
                            } else {
                                badgeJabatan.addClass('bg-secondary').text('Bukan Wali Kelas');
                            }

                            // Set photo
                            var fotoElement = $('#detail-foto');
                            if (data.foto) {
                                fotoElement.attr('src', '/storage/' + data.foto);
                            } else {
                                fotoElement.attr('src', 'https://www.gravatar.com/avatar/' + md5(data.user ? data.user.email : 'default') + '?d=mp&s=150');
                            }

                            // Render subjects many-to-many list
                            var subjectsContainer = $('#detail-subjects-container');
                            subjectsContainer.empty();
                            if (data.mata_pelajaran && data.mata_pelajaran.length > 0) {
                                $.each(data.mata_pelajaran, function(index, subject) {
                                    subjectsContainer.append('<span class="subject-badge">' + subject.nama + '</span>');
                                });
                            } else {
                                subjectsContainer.append('<span class="text-muted font-italic">Belum mengampu mata pelajaran</span>');
                            }

                            // Show the modal
                            $('#modalDetail').modal('show');
                        },
                        error: function(xhr) {
                            Toastify({
                                text: "Gagal mengambil detail profil guru",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast();
                        }
                    });
                });

                // MD5 helper to render Gravatar avatar seamlessly
                function md5(string) {
                    return string.trim().toLowerCase(); // Simulating default Gravatar search easily
                }
            });
        </script>
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
