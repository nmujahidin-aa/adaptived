<?php

namespace App\DataTables\Teacher;

use App\Models\LearningObjective;
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

class LearningObjectivesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<LearningObjective> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->title);
            })
            ->editColumn('title', function($row) {
                $url = route('teacher.learning-objective.edit', $row->id);
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
            ->editColumn('school', function($row) {
                $school = $row->school;
                if (!$school) {
                    return '<span class="badge bg-secondary">Belum ada sekolah</span>';
                }

                $logo = $school->getLogo();
                $shortName = $school->short_name;
                $name = strtoupper($school->name);

                return <<<HTML
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                        <img class="avatar-img" src="{$logo}" alt="School Image">
                        </div>
                        <div class="ms-3">
                        <span class="d-block h5 text-bold mb-0">
                            {$shortName}
                        </span>
                        <span class="d-block fs-5 text-body text-dark">{$name}</span>
                        </div>
                    </div>
                HTML;  
            })
            ->editColumn('action', function($row) {
                $url = route('teacher.learning-objective.edit', ['id' => $row->id]);
                $delete = route('teacher.learning-objective.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action', 'title', 'school', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<LearningObjective>
     */
    public function query(LearningObjective $model): QueryBuilder
    {
        $teacher = Auth::user();
        return $model->where('school_id', $teacher->school_id);
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
            Column::make('title')->addClass('table-column-ps-0')->title('Judul')->width('30%'),
            Column::computed('school')->addClass('table-column-ps-0')->title('Sekolah')->width('30%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LearningObjectives_' . date('YmdHis');
    }
}
