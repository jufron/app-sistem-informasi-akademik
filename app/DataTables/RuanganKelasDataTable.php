<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\RuanganKelas;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RuanganKelasDataTable extends DataTable
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
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="ids[]" value="'.$row->id.'" class="form-check-input row-checkbox">';
            })
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
            ->editColumn('aktif', function ($row) {
                return $row->aktif
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-danger">Tidak Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                return view('dashboard.admin.ruangan-kelas.action', compact('row'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'aktif', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<RuanganKelas>
     */
    public function query(RuanganKelas $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['kelas', 'rombel', 'semester', 'guru'])->latest();

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
            ->dom("<'row'<'col-md-6'B><'col-md-6'f>>".
                  "<'row'<'col-sm-12'tr>>".
                  "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")
            ->buttons([
                Button::make('excel')->exportOptions(['columns' => ':not(.no-export)']),
                Button::make('csv')->exportOptions(['columns' => ':not(.no-export)']),
                Button::make('pdf')->exportOptions(['columns' => ':not(.no-export)']),
                Button::make('print')->exportOptions(['columns' => ':not(.no-export)']),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('checkbox')
                ->title('<input type="checkbox" id="select-all" class="form-check-input">')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(40)
                ->addClass('text-center no-export'),
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
            Column::make('aktif')
                ->title('Status')
                ->searchable(false)
                ->orderable(true),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(150)
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
        return 'RuanganKelas_'.date('YmdHis');
    }
}
