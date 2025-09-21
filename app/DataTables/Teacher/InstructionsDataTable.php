<?php

namespace App\DataTables\Teacher;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;

class InstructionsDataTable extends DataTable
{
    public $worksheet_id;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Instruction> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('teacher.instruction.edit', ['worksheet_id' => $row->worksheet_id, 'id' => $row->id]);
                $content = strip_tags($row->instruction ?? '');
                $excerpt = strlen($content) > 100 
                    ? substr($content, 0, 100) . '...' 
                    : $content;
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="">
                          <span class="d-block h5 mb-0">
                            {$excerpt}
                          </span>
                        </div>
                    </a>
                HTML;  
            })
            ->editColumn('worksheet_id', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-bold">{$row->worksheet->title}</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                $url = route('teacher.instruction.edit', ['worksheet_id' => $row->worksheet_id, 'id' => $row->id]);
                $delete = route('teacher.instruction.single_destroy', ['worksheet_id' => $row->worksheet_id, 'id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action', 'name', 'worksheet_id', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Instruction>
     */
    public function query(Instruction $model): QueryBuilder
    {
        $data = $model->newQuery()
            ->with(['worksheet'])
            ->where('worksheet_id', $this->worksheet_id);
        return $data;
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
            Column::make('name')->addClass('table-column-ps-0 text-wrap')->title('Title')->width('40%'),
            Column::computed('worksheet_id')->addClass('table-column-ps text-wrap')->title('Kegiatan Belajar')->width('30%'),
            Column::computed('action')->title('Aksi')->width('13%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Instructions_' . date('YmdHis');
    }

    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->worksheet_id = $key['worksheet_id'] ?? null;
        } elseif (is_string($key) && $key === 'worksheet_id') {
            $this->worksheet_id = $value;
        }

        return $this;
    }
}
