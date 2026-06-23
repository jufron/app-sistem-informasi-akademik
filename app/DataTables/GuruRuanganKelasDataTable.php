<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\RuanganKelas;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GuruRuanganKelasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<RuanganKelas>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('kelas', function ($row) {
                return $row->kelas ? $row->kelas->nama : '-';
            })
            ->addColumn('rombel', function ($row) {
                return $row->rombel ? $row->rombel->nama : '-';
            })
            ->addColumn('semester', function ($row) {
                return $row->semester ? $row->semester->nama : '-';
            })
            ->addColumn('guru', function ($row) {
                return $row->guru ? $row->guru->nama_lengkap : '-';
            })
            ->addColumn('total_siswa', function ($row) {
                return '<span class="badge bg-primary text-white px-2.5 py-1.5 font-weight-bold" style="border-radius: 20px;"><i class="fas fa-user-graduate me-1"></i> '.$row->anggota_kelas_count.' Siswa</span>';
            })
            ->editColumn('aktif', function ($row) {
                return $row->aktif
                    ? '<span class="badge bg-success px-3 py-1.5 rounded-pill text-white"><i class="fas fa-check-circle me-1"></i> Aktif</span>'
                    : '<span class="badge bg-danger px-3 py-1.5 rounded-pill text-white"><i class="fas fa-times-circle me-1"></i> Tidak Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                $detailUrl = route('dashboard.guru.ruangan-kelas.show', $row->id);
                return '
                    <a href="'.$detailUrl.'" class="btn btn-sm btn-info btn-round px-3 py-1.5 shadow-sm d-inline-flex align-items-center gap-1 btn-view-class-details" style="transition: all 0.2s ease;">
                        <i class="fas fa-eye"></i> Detail Kelas
                    </a>
                ';
            })
            ->setRowId('id')
            ->rawColumns(['total_siswa', 'aktif', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<RuanganKelas>
     */
    public function query(RuanganKelas $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['kelas', 'rombel', 'semester', 'guru'])
            ->withCount('anggotaKelas')
            ->latest();

        if ($this->request()->filled('semester_id')) {
            $query->where('semester_id', $this->request()->get('semester_id'));
        }

        if ($this->request()->filled('kelas_id')) {
            $query->where('kelas_id', $this->request()->get('kelas_id'));
        }

        if ($this->request()->filled('rombel_id')) {
            $query->where('rombel_id', $this->request()->get('rombel_id'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('ruangankelas-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(10, 'desc')
            ->selectStyleSingle()
            ->dom("<'row'<'col-md-6'l><'col-md-6'f>>".
                  "<'row'<'col-sm-12'tr>>".
                  "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center no-export'),
            Column::computed('kelas')
                ->title('Kelas')
                ->searchable(true)
                ->orderable(false),
            Column::computed('rombel')
                ->title('Rombongan Belajar')
                ->searchable(true)
                ->orderable(false),
            Column::computed('semester')
                ->title('Semester')
                ->searchable(true)
                ->orderable(false),
            Column::computed('guru')
                ->title('Wali Kelas')
                ->searchable(true)
                ->orderable(false),
            Column::make('tahun_angkatan')
                ->title('Tahun Angkatan')
                ->searchable(true)
                ->orderable(true),
            Column::make('tahun_ajaran')
                ->title('Tahun Ajaran')
                ->searchable(true)
                ->orderable(true),
            Column::computed('total_siswa')
                ->title('Total Siswa')
                ->exportable(true)
                ->searchable(false)
                ->orderable(false),
            Column::make('aktif')
                ->title('Status')
                ->searchable(false)
                ->orderable(true),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center no-export'),
            Column::make('created_at')
                ->visible(false)
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(true),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'GuruRuanganKelas_'.date('YmdHis');
    }
}
