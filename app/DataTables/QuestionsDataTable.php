<?php

namespace App\DataTables;

use App\Helpers\DataTableHelper;
use App\Models\Question;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class QuestionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Question> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->question);
            })
            ->editColumn('question', function($row) {
                return $row->question;
            })
            ->editColumn('type', function($row) {
                return $row->type;
            })
            ->editColumn('action', function($row) {
                $url = route('teacher.assesment.question.edit', ['variable_id' => $row->assesment_variable_id,'id' => $row->id]);
                $delete = route('teacher.assesment.question.single_destroy', ['variable_id' => $row->assesment_variable_id,'id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action', 'type', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Question>
     */
    public function query(Question $model): QueryBuilder
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
            Column::make('question')->addClass('table-column-ps-0')->title('Pertanyaan')->width('50%'),
            Column::make('type')->addClass('table-column-ps-0')->title('Tipe Soal')->width('25%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Questions_' . date('YmdHis');
    }
}
