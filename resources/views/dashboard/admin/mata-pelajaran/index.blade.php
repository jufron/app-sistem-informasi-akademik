<x-dashboard.layoutDashboard.app title="Mata Pelajaran">
    <x-slot:myStyle>
        {{-- ? sweetalert 2 lib --}}
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

        {{-- ? toastify css  --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- DataTables & Buttons Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

        <!-- Custom Premium Checkbox Styling -->
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
        </style>
    </x-slot:myStyle>

        <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Mata Pelajaran</h4>
        </div>
        <div class="card-body">
            <div class="my-4">
                <a href="{{ route('dashboard.mata-pelajaran.create') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i> Tambah Mapel
                </a>
                <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-round d-none">
                    <i class="fa fa-trash"></i> Hapus Terpilih
                </button>
            </div>

            <form id="bulk-delete-form" action="{{ route('dashboard.mata-pelajaran.bulk-destroy') }}" method="POST" style="display: none;">
                @csrf
                <div id="bulk-delete-inputs"></div>
            </form>

            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover mt-4 w-100'], true) !!}
            </div>

            <!-- Modal Detail Mata Pelajaran -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                        <div class="modal-header bg-primary text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                            <h5 class="modal-title font-weight-bold" id="modalDetailLabel">
                                <i class="fa fa-info-circle me-2"></i> Detail Mata Pelajaran
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <table class="table table-borderless m-0">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold text-secondary" style="width: 35%;">Nama Mapel</td>
                                        <td style="width: 5%;">:</td>
                                        <td id="detail-nama" class="font-weight-bold text-dark">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-secondary">Deskripsi</td>
                                        <td>:</td>
                                        <td id="detail-deskripsi" class="text-dark" style="white-space: pre-line;">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-secondary">Tanggal Buat</td>
                                        <td>:</td>
                                        <td id="detail-created" class="text-dark">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold text-secondary">Terakhir Diubah</td>
                                        <td>:</td>
                                        <td id="detail-updated" class="text-dark">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer bg-light border-0" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
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
                        // Check if all individual row checkboxes are checked
                        var allChecked = $('.row-checkbox').length === $('.row-checkbox:checked').length;
                        $('#select-all').prop('checked', allChecked);
                    }
                    toggleBulkDeleteButton();
                });

                // Retrieve the DataTable instance
                var tableId = 'matapelajaran-table';
                var table = window.LaravelDataTables && window.LaravelDataTables[tableId];

                if (table) {
                    // Reset select all checkbox on DataTable redraw (e.g. pagination, sorting, search)
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
                        text: "Anda akan menghapus " + count + " data mata pelajaran terpilih secara permanen!",
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
                        text: "Data mata pelajaran ini akan dihapus secara permanen!",
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
                            $('#detail-nama').text(data.nama);
                            $('#detail-deskripsi').text(data.deskripsi || '-');
                            
                            // Format date cleanly with fallback if browser parsing returns Invalid Date
                            var parseDate = function(dateStr) {
                                if (!dateStr) return '-';
                                var parsed = new Date(dateStr);
                                return isNaN(parsed.getTime()) ? dateStr : parsed.toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' });
                            };
                            
                            $('#detail-created').text(parseDate(data.created_at));
                            $('#detail-updated').text(parseDate(data.updated_at));
                            
                            // Show the modal
                            $('#modalDetail').modal('show');
                        },
                        error: function(xhr) {
                            Toastify({
                                text: "Gagal mengambil data mata pelajaran",
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
