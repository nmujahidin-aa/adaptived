<?php

namespace App\DataTables\Admin;

use App\Helpers\DataTableHelper;
use App\Models\School;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SchoolsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<School> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('admin.school.edit', $row->id);
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="avatar">
                          <img class="avatar-img" src="{$row->getLogo()}" alt="School Image" style="object-fit: cover; object-position: center; width: 100%; height: 100%; display: block;">
                        </div>
                        <div class="ms-3">
                          <span class="d-block h5 text-bold mb-0">
                            {$row->short_name}
                          </span>
                          <span class="d-block fs-5 text-body text-dark" style="text-transform: uppercase;">{$row->name}</span>
                        </div>
                    </a>
                HTML;  
            })
            ->editColumn('contact', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-body"><i class="bi bi-telephone-fill"></i> {$row->phone}</span>
                    <span class="d-block fs-5 text-body"><i class="bi bi-envelope-fill"></i> {$row->email}</span>
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
                $url = route('admin.school.edit', ['id' => $row->id]);
                $delete = route('admin.school.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action', 'name', 'contact', 'status', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<School>
     */
    public function query(School $model): QueryBuilder
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
            Column::make('name')->addClass('table-column-ps-0')->title('Nama Sekolah')->width('40%'),
            Column::computed('contact')->title('Kontak')->width('20%'),
            Column::computed('status')->title('Status')->width('15%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Schools_' . date('YmdHis');
    }
}
