<?php

namespace App\DataTables\Teacher;

use App\Models\Analysis;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DataTableHelper;

class AnalysisDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Analysi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('teacher.student.edit', $row->id);
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{$row->getAvatar()}" alt="School Image">
                        </div>
                        <div class="ms-3">
                          <span class="d-block h5 text-bold mb-0" style="text-transform: uppercase;">
                            {$row->name}
                          </span>
                          <span class="d-block fs-5 text-body text-dark">{$row->email}</span>
                        </div>
                    </a>
                HTML;  
            });
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Analysis>
     */
    public function query(Analysis $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('analysis-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Analysis_' . date('YmdHis');
    }
}
