<x-dashboard.layoutDashboard.app title="Penilaian Kurikulum Merdeka">
    <x-slot:myStyle>
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        
        <style>
            .btn-grade-classroom {
                background: linear-gradient(135deg, #1572e8 0%, #064fa9 100%);
                border: none;
                color: white !important;
                font-weight: 600;
                border-radius: 30px !important;
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            .btn-grade-classroom:hover {
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
                        <i class="fas fa-star-half-alt text-primary me-2"></i> Input Penilaian
                    </h4>
                    <p class="card-category text-muted m-0 mt-1">Pilih kelas di mana Anda mengajar untuk memasukkan atau memperbarui nilai formatif dan sumatif siswa.</p>
                </div>
                <div class="card-body">
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
    </x-slot:myScript>
</x-dashboard.layoutDashboard.app>
