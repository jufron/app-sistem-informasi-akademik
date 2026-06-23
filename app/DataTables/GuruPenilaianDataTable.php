<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\RuanganKelas;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GuruPenilaianDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                $gradingUrl = route('dashboard.guru.penilaian.show', $row->id);
                return '
                    <a href="'.$gradingUrl.'" class="btn btn-sm btn-primary btn-round px-3 py-1.5 shadow-sm d-inline-flex align-items-center gap-1 btn-grade-classroom" style="transition: all 0.2s ease;">
                        <i class="fas fa-edit"></i> Input Nilai
                    </a>
                ';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<RuanganKelas>
     */
    public function query(RuanganKelas $model): QueryBuilder
    {
        $guruId = auth()->user()->guru->id ?? 0;

        return $model->newQuery()
            ->whereExists(function ($query) use ($guruId) {
                $query->select(DB::raw(1))
                    ->from('jadwal_pelajaran')
                    ->whereColumn('jadwal_pelajaran.kelas_id', 'ruangan_kelas.kelas_id')
                    ->whereColumn('jadwal_pelajaran.rombel_id', 'ruangan_kelas.rombel_id')
                    ->whereColumn('jadwal_pelajaran.semester_id', 'ruangan_kelas.semester_id')
                    ->where('jadwal_pelajaran.guru_id', $guruId);
            })
            ->with(['kelas', 'rombel', 'semester'])
            ->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('gurupenilaian-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(4, 'desc')
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
            Column::make('tahun_ajaran')
                ->title('Tahun Ajaran')
                ->searchable(true)
                ->orderable(true),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center no-export'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'GuruPenilaian_'.date('YmdHis');
    }
}
