<?php

namespace App\DataTables;

use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\DataTableHtml;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

final class MataPelajaranDataTableHtml extends DataTableHtml
{
    protected string $tableId = 'matapelajaran-table';

    public function options(Builder $builder): void
    {
        $builder
            ->orderBy(1)
            ->languageSearchPlaceholder('Search...');
    }

    /**
     * @return array<int, \Yajra\DataTables\Html\Column>
     */
    public function columns(): array
    {
        return [
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * @return array<int, \Yajra\DataTables\Html\Button>
     */
    public function buttons(): array
    {
        return [
            Button::make('excel'),
            Button::make('csv'),
            Button::make('pdf'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
    }

    /**
     * @return array<int, \Yajra\DataTables\Html\Editor\Editor>
     */
    public function editors(): array
    {
        return [
//             Editor::make()
//                ->fields([
//                     Fields\Text::make('field_name'),
//                ]),
        ];
    }
}
