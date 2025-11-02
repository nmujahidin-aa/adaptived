<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Teacher\GroupWorksheetsDataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\GroupAnswer;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Http;
use App\Helpers\HttpResponse;
use App\Models\GroupWorksheet;
use Illuminate\Http\Response;

class GroupAnswerController extends Controller
{
    protected $view;
    protected $route;
    protected $groupAnswer;

    public function __construct(){
        $this->view = "pages.teacher.group-answer.";
        $this->route = "teacher.worksheet-group-answer.";
        $this->groupAnswer = new GroupAnswer();
    }

    public function index(GroupWorksheetsDataTable $dataTable, $worksheet_id)
    {
        $group_worksheet_count = GroupWorksheet::where('worksheet_id', $worksheet_id)
            ->get(['group_id', 'worksheet_id'])
            ->count();
        return $dataTable->with(['worksheet_id' => $worksheet_id])
        ->render($this->view.'index', [
            'worksheet_id' => $worksheet_id,
            'group_worksheet_count' => $group_worksheet_count,
        ]);
    }

    public function show($worksheet_id, $group_id)
    {
        $answers = $this->groupAnswer
            ->where('worksheet_id', $worksheet_id)
            ->where('group_id', $group_id)
            ->with(['group', 'instruction'])
            ->get();

        $group = $answers->first()?->group;
        $worksheet = Worksheet::find($worksheet_id);

        $groupWorksheet = \App\Models\GroupWorksheet::where('worksheet_id', $worksheet_id)
            ->where('group_id', $group_id)
            ->first();
            
        return view($this->view . 'show', [
            'answers' => $answers,
            'group' => $group,
            'worksheet_id' => $worksheet_id,
            'worksheet' => $worksheet,
            'groupWorksheet' => $groupWorksheet,
        ]);
    }

    public function grade(Request $request, $worksheet_id, $group_id)
    {
        try {
            $request->validate([
                'grade' => 'required|numeric|min:0|max:100',
            ]);

            $groupWorksheet = GroupWorksheet::where('worksheet_id', $worksheet_id)
                ->where('group_id', $group_id)
                ->firstOrFail();

            $groupWorksheet->grade = $request->input('grade');
            $groupWorksheet->save();

            session()->flash('alert.grade.success', 'Nilai berhasil disimpan.');

            return redirect()->back();

        } catch (\Throwable $e) {
            report($e);
            session()->flash('alert.grade.error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}
