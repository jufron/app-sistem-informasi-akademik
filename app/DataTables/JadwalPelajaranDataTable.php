<?php

declare(strict_types=1);

namespace App\DataTables;

use App\Models\JadwalPelajaran;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JadwalPelajaranDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<JadwalPelajaran>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="ids[]" value="'.$row->id.'" class="form-check-input row-checkbox">';
            })
            ->addColumn('mata_pelajaran', function ($row) {
                return $row->mataPelajaran ? $row->mataPelajaran->nama : '-';
            })
            ->addColumn('guru', function ($row) {
                return $row->guru ? $row->guru->nama_lengkap : '-';
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
            ->addColumn('ganjil_genap', function ($row) {
                return $row->ganjil_genap ?? '-';
            })
            ->addColumn('waktu', function ($row) {
                $mulai = date('H:i', strtotime($row->jam_mulai));
                $selesai = date('H:i', strtotime($row->jam_selesai));

                return '<span class="badge badge-secondary fs-8"><i class="far fa-clock me-1"></i> '.$mulai.' - '.$selesai.'</span>';
            })
            ->editColumn('warna', function ($row) {
                return '<div class="d-flex align-items-center justify-content-center">
                    <span class="d-inline-block rounded-circle shadow-sm" style="width: 20px; height: 20px; background-color: '.$row->warna.'; border: 2px solid #ffffff;"></span>
                    <span class="ms-2 text-secondary font-monospace fs-8">'.strtoupper($row->warna).'</span>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return view('dashboard.admin.jadwal-pelajaran.action', compact('row'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['checkbox', 'waktu', 'warna', 'action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<JadwalPelajaran>
     */
    public function query(JadwalPelajaran $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['guru', 'mataPelajaran', 'kelas', 'rombel', 'semester']);

        if ($this->request()->filled('kelas_id')) {
            $query->where('kelas_id', $this->request()->get('kelas_id'));
        }
        if ($this->request()->filled('rombel_id')) {
            $query->where('rombel_id', $this->request()->get('rombel_id'));
        }
        if ($this->request()->filled('semester_id')) {
            $query->where('semester_id', $this->request()->get('semester_id'));
        }
        if ($this->request()->filled('hari')) {
            $query->where('hari', $this->request()->get('hari'));
        }
        if ($this->request()->filled('jam_mulai')) {
            $query->where('jam_mulai', 'like', $this->request()->get('jam_mulai').'%');
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jadwalpelajaran-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2)
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
            Column::computed('mata_pelajaran')
                ->title('Mata Pelajaran')
                ->searchable(true)
                ->orderable(false),
            Column::computed('guru')
                ->title('Guru / Pengampu')
                ->searchable(true)
                ->orderable(false),
            Column::computed('kelas')
                ->title('Kelas')
                ->searchable(true)
                ->orderable(false),
            Column::computed('rombel')
                ->title('Rombel')
                ->searchable(true)
                ->orderable(false),
            Column::computed('semester')
                ->title('Semester')
                ->searchable(true)
                ->orderable(false),
            Column::computed('ganjil_genap')
                ->title('Periode')
                ->searchable(true)
                ->orderable(false),
            Column::make('hari')
                ->title('Hari')
                ->searchable(true)
                ->orderable(true),
            Column::computed('waktu')
                ->title('Waktu')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false),
            Column::make('ruangan')
                ->title('Ruangan')
                ->searchable(true)
                ->orderable(true),
            Column::make('warna')
                ->title('Warna Event')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
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
        return 'JadwalPelajaran_'.date('YmdHis');
    }
}
