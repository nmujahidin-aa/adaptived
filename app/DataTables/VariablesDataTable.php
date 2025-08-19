<?php

namespace App\DataTables;

use App\Helpers\DataTableHelper;
use App\Models\Variable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
            ->editColumn('short_answer_count', function($row) {
                return $row->short_answer_questions_count . ' Soal' ;
            })
            ->editColumn('essay_count', function($row) {
                return $row->essay_questions_count . ' Soal';
            })
            ->editColumn('action', function($row) {
                $add_route = route('teacher.assesment.question.index', ['variable_id' => $row->id]);
                $url = route('teacher.assesment.edit', ['id' => $row->id]);
                $delete = route('teacher.assesment.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButtonAssesment($row, $add_route, $url, $delete);
            })
            ->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Variable>
     */
    public function query(Variable $model): QueryBuilder
    {
        return $model->newQuery()->withCount(['shortAnswerQuestions', 'essayQuestions']);
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
            Column::computed('short_answer_count')->title('Soal Singkat')->width('12.5%'),
            Column::computed('essay_count')->title('Soal Esai')->width('12.5%'),
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
