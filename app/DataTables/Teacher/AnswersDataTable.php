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
                return DataTableHelper::checkbox($row, $row->answer);
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
            ->editColumn('answer', function($row) {
                $rawHtml = $row->trixRender('answer');
                $plain = strip_tags($rawHtml);

                $excerpt = strlen($plain) > 100
                    ? substr($plain, 0, 100) . '...'
                    : $plain;

                return "<span class='d-block fs-5 text-bold'>{$excerpt}</span>";
            })
            ->editColumn('analysis', function ($row) {
                if (!$row->analysis) {
                    return "<em>Belum dianalisis</em>";
                }

                $rawHtml = $row->analysis;
                $plain = trim(strip_tags($rawHtml));
                $excerpt = strlen($plain) > 100
                    ? substr($plain, 0, 100) . '...'
                    : $plain;

                $safeExcerpt = e($excerpt);

                return "<span class='d-block fs-5'>{$safeExcerpt}</span>";
            })
            ->editColumn('grade', function($row) {
                return <<<HTML
                    <span class="d-block fs-5 text-bold">-</span>
                HTML;
            })
            ->editColumn('action', function($row) {
                if ($row->assesment_id && $row->id) {
                    $url = route('teacher.answer.show', ['assesment_id' => $row->assesment_id, 'id' => $row->id]);
                    $storeRoute = route('teacher.answer.analyze', ['assesment_id' => $row->assesment_id, 'id' => $row->id]);
                    return DataTableHelper::actionButtonAnswer($row, $url, $storeRoute);
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
            Column::computed('name')->addClass('table-column-ps-0')->title('Siswa')->width('15%'),
            Column::computed('answer')->addClass('table-column-ps text-wrap')->title('Jawaban')->width('30%'),
            Column::computed('analysis')->addClass('table-column-ps-0 text-wrap')->title('Analisis AI')->width('30%'),
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

    /**
     * Terima parameter dari controller (agar assesment_id tidak null).
     */
    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            $this->assesment_id = $key['assesment_id'] ?? null;
        } elseif (is_string($key) && $key === 'assesment_id') {
            $this->assesment_id = $value;
        }

        return $this;
    }
}
