<?php

namespace App\DataTables\Admin;

use App\Models\Variable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;

class VariablesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Variable> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->addColumn('name', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-bold"><i class="bi bi-{$row->icon} text-dark me-1"></i>{$row->name}</span>
                HTML;
            })
            ->editColumn('status', function($row) {
                $status_icon = $row->status === 'active' ? 'bi-patch-check-fill' : 'bi-dash-circle-fill';
                $status_text = $row->status === 'active' ? 'Aktif' : 'Nonaktif';
                $status_colour = $row->status === 'active' ? 'success' : 'secondary';
                return <<<HTML
                    <span class="d-block fs-5 text-body"><i class="bi {$status_icon} text-{$status_colour}"></i> {$status_text}</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                $url = route('admin.variable.edit', ['id' => $row->id]);
                $delete = route('admin.variable.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action', 'name', 'status', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Variable>
     */
    public function query(Variable $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable')
            ->orderBy(2, 'desc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            DataTableHelper::addCheckbox()->width('5%'),
            Column::make('name')->addClass('table-column-ps-0')->title('Nama Variabel')->width('50%'),
            Column::computed('status')->title('Status')->width('12.5%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Variables_' . date('YmdHis');
    }
}
