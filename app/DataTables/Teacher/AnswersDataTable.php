<?php

namespace App\DataTables\Teacher;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;

class AnswersDataTable extends DataTable
{
    /**
     * Properti publik untuk menyimpan ID penilaian.
     */
    public $assesment_id;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Answer> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return DataTableHelper::checkbox($row, $row->name);
            })
            ->editColumn('name', function($row) {
                $url = route('teacher.answer.show', ['assesment_id' => $row->assesment_id, 'id' => $row->id]);
                return <<<HTML
                    <a class="d-flex align-items-center" href="{$url}">
                        <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{$row->user->getAvatar()}" alt="User Image">
                        </div>
                        <div class="ms-3">
                          <span class="d-block h5 text-bold mb-0" style="text-transform: uppercase;">
                            {$row->user->name}
                          </span>
                          <span class="d-block fs-5 text-body text-dark">{$row->user->email}</span>
                        </div>
                    </a>
                HTML;  
            })
            // Perbaikan ada di sini
            ->editColumn('answer', function($row) {
                // Menggunakan $row->trix('answer') untuk merender konten dari tabel trix_rich_texts
                return <<<HTML
                    <span class="d-block fs-5 text-bold">{!! $row->trix('answer') !!}</span>
                HTML;
            })
            ->editColumn('analysis', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-bold">{$row->analysis}</span>
                HTML;
            })
            ->editColumn('grade', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-bold">90</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                // Pastikan $row->assesment_id dan $row->id ada sebelum memanggil route()
                if ($row->assesment_id && $row->id) {
                    $url = route('teacher.answer.show', ['assesment_id' => $row->assesment_id, 'id' => $row->id]);
                    $delete = route('teacher.answer.single_destroy', ['assesment_id' => $row->assesment_id, 'id' => $row->id]);
                    return DataTableHelper::actionButton($row, $url, $delete);
                }
                return '';
            })
            ->rawColumns(['action', 'name', 'answer','analysis', 'grade','checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Answer>
     */
    public function query(Answer $model): QueryBuilder
    {
        // Gunakan properti yang telah diatur dari controller untuk memfilter data
        $data = $model->newQuery()
            ->with(['user'])
            ->where('assesment_id', $this->assesment_id);
        
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
            Column::make('name')->addClass('table-column-ps-0')->title('Siswa')->width('15%'),
            Column::computed('answer')->addClass('table-column-ps-0')->title('Jawaban')->width('30%'),
            Column::computed('analysis')->addClass('table-column-ps-0')->title('Analisis AI')->width('30%'),
            Column::computed('grade')->title('Nilai')->width('12%'),
            Column::computed('action')->title('Aksi')->width('13%'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Answers_' . date('YmdHis');
    }
}
