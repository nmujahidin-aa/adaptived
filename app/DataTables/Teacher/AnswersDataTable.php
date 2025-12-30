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
use Illuminate\Support\Facades\DB;

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
        ->filterColumn('name', function ($query, $keyword) {
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
            });
        })
        ->editColumn('name', function($row) {
            $url = route('teacher.answer.show', ['assesment_id' => $row->assesment_id, 'id' => $row->user_id]);
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
        ->editColumn('status', function ($row) {
            $total = (int) $row->total_answers;
            $done  = (int) $row->analyzed_answers;

            $percent = $total > 0 ? round(($done / $total) * 100) : 0;

            $color = match (true) {
                $percent == 100 => 'bg-success',
                $percent >= 50   => 'bg-warning',
                default          => 'bg-danger',
            };

            return <<<HTML
                <div class="mb-1">
                    <span class="badge bg-soft-dark text-dark">
                        {$done} / {$total} dianalisis
                    </span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar {$color}" role="progressbar"
                        style="width: {$percent}%"
                        aria-valuenow="{$percent}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            HTML;
        })
        ->editColumn('grade', function($row) {
            return <<<HTML
                <span class="d-block fs-5 text-bold">-</span>
            HTML;
        })
        ->editColumn('action', function($row) {
            $route = route('teacher.answer.show', ['assesment_id' => $row->assesment_id, 'id' => $row->user_id]);
            return DataTableHelper::actionButtonGroupAnswerDetail($row, $route);
            
        })
        ->rawColumns(['name', 'status', 'grade','action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Answer>
     */
    public function query(Answer $model): QueryBuilder
    {
        $answer = $model->newQuery()
            ->select([
                'user_id',
                'assesment_id',
                DB::raw('COUNT(*) as total_answers'),
                DB::raw('SUM(CASE WHEN analysis IS NOT NULL THEN 1 ELSE 0 END) as analyzed_answers'),
            ])
            ->with('user')
            ->where('assesment_id', $this->assesment_id)
            ->groupBy('user_id', 'assesment_id');
        return $answer;
        
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
            Column::computed('name')->addClass('table-column')->title('Siswa')->searchable(true)->width('25%'),
            Column::computed('status')->title('Status')->width('12%'),
            Column::computed('grade')->title('Nilai')->width('12%'),
            Column::computed('action')->title('Aksi')->width('13%'),
        ];
    }

    protected function filename(): string
    {
        return 'Answers_' . date('YmdHis');
    }

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