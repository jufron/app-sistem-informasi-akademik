<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GuruDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Guru> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="ids[]" value="' . $row->id . '" class="form-check-input row-checkbox">';
            })
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->jenisKelamin ? $row->jenisKelamin->nama : '-';
            })
            ->editColumn('agama', function ($row) {
                return $row->agama ? $row->agama->nama : '-';
            })
            ->editColumn('tipe', function ($row) {
                if ($row->tipe === 'Kepala Sekolah') {
                    return '<span class="badge bg-danger">Kepala Sekolah</span>';
                } elseif ($row->tipe === 'Wali Kelas') {
                    return '<span class="badge bg-success">Wali Kelas</span>';
                }
                return '<span class="badge bg-secondary">Bukan Wali Kelas</span>';
            })
            ->editColumn('status', function ($row) {
                if ($row->status === 'Aktif') {
                    return '<span class="badge bg-success">Aktif</span>';
                } elseif ($row->status === 'Cuti') {
                    return '<span class="badge bg-warning text-dark">Cuti</span>';
                }
                return '<span class="badge bg-danger">Nonaktif</span>';
            })
            ->addColumn('action', function ($row) {
                return view('dashboard.admin.guru.action', compact('row'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'tipe', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Guru>
     */
    public function query(Guru $model): QueryBuilder
    {
        return $model->newQuery()->with(['user', 'jenisKelamin', 'agama', 'mataPelajaran']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('guru-table')
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
            Column::make('nip')
                  ->title('NIP')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('nama_lengkap')
                  ->title('Nama Lengkap')
                  ->searchable(true)
                  ->orderable(true),
            Column::computed('jenis_kelamin')
                  ->title('Jenis Kelamin')
                  ->searchable(false)
                  ->orderable(false),
            Column::computed('agama')
                  ->title('Agama')
                  ->searchable(false)
                  ->orderable(false),
            Column::make('tipe')
                  ->title('Jabatan')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('status')
                  ->title('Status')
                  ->searchable(true)
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
        return 'Guru_' . date('YmdHis');
    }
}
