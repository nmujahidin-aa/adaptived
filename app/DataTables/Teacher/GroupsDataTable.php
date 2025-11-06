<?php

namespace App\DataTables\Teacher;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;   
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;
use Illuminate\Support\Facades\Auth;

class GroupsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Group> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('teacher.group.edit', $row->id);
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="">
                          <span class="d-block h5 text-bold mb-0" style="text-transform: uppercase;">
                            {$row->name}
                          </span>
                        </div>
                    </a>
                HTML;  
            })
            ->editColumn('worksheet', function($row) {
                $count = $row->worksheets()->count();
                $badgeClass = $count === 0 ? 'danger' : 'success';
                return <<<HTML
                    <span class="badge bg-{$badgeClass}">{$count} Kegiatan Belajar</span>
                HTML;
            })
            ->editColumn('member', function($row) {
                $members = $row->members;

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
            ->editColumn('action', function($row) {
                $url = route('teacher.group.edit', ['id' => $row->id]);
                $delete = route('teacher.group.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action','name', 'worksheet','member','checkbox']);

    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Group>
     */
    public function query(Group $model): QueryBuilder
    {
        return $model->where('school_id', Auth::user()->school_id)->newQuery();
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
            Column::make('name')->addClass('table-column-ps-0 text-wrap')->title('Nama Kelompok')->width('30%'),
            Column::computed('worksheet')->addClass('table-column-ps-0 text-wrap')->title('Kegiatan Belajar')->width('30%'),
            Column::computed('member')->addClass('table-column-ps-0 text-wrap')->title('Anggota')->width('30%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Groups_' . date('YmdHis');
    }
}
