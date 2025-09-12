<?php

namespace App\DataTables\Admin;

use App\Models\User;
use App\Helpers\DataTableHelper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Enums\RoleEnum;

class TeachersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('admin.teacher.edit', $row->id);
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
            ->editColumn('gender', function($row) {
                $gender_icon = $row->gender === 'L' ? 'bi-gender-male' : 'bi-gender-female';
                $gender_text = $row->gender === 'L' ? 'Laki-laki' : 'Perempuan';
                return <<<HTML
                    <span class="d-block fs-5 text-body"><i class="bi {$gender_icon} me-1"></i> {$gender_text}</span>
                HTML;
            })
            ->editColumn('phone', function($row) {
                $phone = $row->phone ? $row->phone : 'belum diatur';
                $text_color = $row->phone ? 'text-body' : 'text-danger';
                return <<<HTML
                    <span class="d-block fs-5 {$text_color}"><i class="bi bi-telephone-fill me-1"></i> {$phone}</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                $url = route('admin.teacher.edit', ['id' => $row->id]);
                $delete = route('admin.teacher.single_destroy', ['id' => $row->id]);
                return DataTableHelper::actionButton($row, $url, $delete);
            })
            ->rawColumns(['action', 'name', 'gender', 'phone', 'school', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->role(RoleEnum::TEACHER);
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
            Column::make('name')->addClass('table-column-ps-0')->title('Nama Siswa')->width('30%'),
            Column::computed('school')->addClass('table-column-ps-0')->title('Sekolah')->width('30%'),
            Column::computed('gender')->title('Jenis Kelamin')->width('15%'),
            Column::computed('phone')->title('Telepon')->width('15%'),
            Column::computed('action')->title('Aksi')->width('20%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Guru_' . date('YmdHis');
    }
}
