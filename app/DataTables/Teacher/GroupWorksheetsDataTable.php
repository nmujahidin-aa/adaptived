<?php

namespace App\DataTables\Teacher;

use App\Models\GroupWorksheet;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;

class GroupWorksheetsDataTable extends DataTable
{
    /**
     * Properti publik untuk menyimpan ID worksheet.
     */
    public $worksheet_id;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<GroupWorksheet> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('teacher.worksheet-group-answer.show', ['worksheet_id' => $row->worksheet_id, 'group_id' => $row->group_id]);
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="">
                          <span class="d-block h5 text-bold mb-0" style="text-transform: uppercase;">
                            {$row->group->name}
                          </span>
                        </div>
                    </a>
                HTML;  
            })

            ->editColumn('member', function($row) {
                $members = $row->group->members;

                if ($members->isEmpty()) {
                    return '<span class="badge bg-secondary">Belum ada anggota</span>';
                }

                $leader = $members->firstWhere('pivot.role', 'leader');
                $teamMembers = $members->filter(function($member) {
                    return $member->pivot->role === 'member';
                });

                $html = '<div class="avatar-group avatar-circle">';

                if ($leader) {
                    $html .= <<<HTML
                        <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{$leader->name} (Ketua)">
                            <img class="avatar-img" src="{$leader->getAvatar()}" alt="{$leader->name}">
                        </a>
                    HTML;
                }

                if ($teamMembers->isNotEmpty()) {
                    foreach ($teamMembers as $member) {
                        $html .= <<<HTML
                            <a class="avatar" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="{$member->name}">
                                <img class="avatar-img" src="{$member->getAvatar()}" alt="{$member->name}">
                            </a>
                        HTML;
                    }
                }

                $html .= '</div>';

                return $html;
            })
            ->editColumn('grade', function($row) {
                $grade = $row->grade ?? '-';
                return <<<HTML
                    <span class="d-block fs-5 text-bold">{$grade}</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                if ($row->worksheet_id && $row->group_id) {
                    $url = route('teacher.worksheet-group-answer.show', ['worksheet_id' => $row->worksheet_id, 'group_id' => $row->group_id]);
                    return DataTableHelper::actionButtonGroupAnswerDetail($row, $url);
                }
                return '';
            })
            ->rawColumns(['action', 'name', 'member', 'grade', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<GroupWorksheet>
     */
    public function query(GroupWorksheet $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['group'])
            ->where('worksheet_id', $this->worksheet_id);
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
            Column::make('name')->addClass('table-column-ps-0')->title('Kelompok')->width('15%'),
            Column::computed('member')->title('Anggota')->width('15%'),
            Column::computed('grade')->title('Nilai')->width('12%'),
            Column::computed('action')->title('Aksi')->width('13%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'GroupWorksheets_' . date('YmdHis');
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
