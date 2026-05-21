<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MataPelajaranDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<MataPelajaran> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="ids[]" value="' . $row->id . '" class="form-check-input row-checkbox">';
            })
            ->editColumn('deskripsi', function ($row) {
                return str($row->deskripsi)->limit(50);
            })
            ->addColumn('action', function ($row) {
                return view('dashboard.admin.mata-pelajaran.action', compact('row'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<MataPelajaran>
     */
    public function query(MataPelajaran $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('matapelajaran-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2)
                    ->selectStyleSingle()
                    ->dom("<'row'<'col-md-6'B><'col-md-6'f>>" .
                          "<'row'<'col-sm-12'tr>>" .
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
            Column::make('nama')
                  ->title('Nama Mata Pelajaran')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('deskripsi')
                  ->title('Deskripsi')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('created_at')
                  ->title('Tanggal Buat')
                  ->searchable(false)
                  ->orderable(true),
            Column::computed('action')
                  ->title('Aksi')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center no-export'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MataPelajaran_' . date('YmdHis');
    }
}
