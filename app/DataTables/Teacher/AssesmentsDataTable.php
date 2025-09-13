<?php

namespace App\DataTables\Teacher;

use App\Models\Assesment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;

class AssesmentsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Assesment> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('title', function($row) {
                $url = route('teacher.assesment.edit', $row->id);
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="ms-3">
                          <span class="d-block h5 text-bold mb-0" style="text-transform: uppercase;">
                            {$row->title}
                          </span>
                        </div>
                    </a>
                HTML;  
            })
            ->editColumn('variable', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-bold"><i class="bi bi-{$row->variable->icon} text-dark me-1"></i>{$row->variable->name}</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                $url = route('teacher.assesment.edit', ['id' => $row->id]);
                $delete = route('teacher.assesment.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action','title', 'variable', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Assesment>
     */
    public function query(Assesment $model): QueryBuilder
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
            Column::make('title')->addClass('table-column-ps-0')->title('Assesment')->width('30%'),
            Column::computed('variable')->addClass('table-column-ps-0')->title('Variabel')->width('30%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Assesments_' . date('YmdHis');
    }
}
