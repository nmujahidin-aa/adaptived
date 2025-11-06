<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\GroupAnswerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Worksheet;
use Illuminate\Support\Facades\DB;
use App\Models\GroupAnswer;

class WorksheetController extends Controller
{
    protected $view;
    protected $route;

    public function __construct(){
        $this->route = 'worksheet.';
        $this->view = 'pages.student.worksheet.';
    }

    public function index()
    {
        $user = Auth::user();

        $worksheets = Worksheet::with([
                'groups.members',
                'groups.answers',
                'groups.instructions'
            ])
            ->withCount('instructions')
            ->where('school_id', $user->school_id)
            ->get();

        return view($this->view . 'index', compact('worksheets'));
    }


    public function show($id)
    {
        $user = Auth::user();

        $worksheet = Worksheet::with('groups.members')->findOrFail($id);
        $group = $worksheet->groups
            ->first(fn($g) => $g->members->contains($user->id));

        if (!$group) {
            return redirect()->route('worksheet.index')
                ->with('error', 'Anda belum tergabung dalam kelompok untuk kegiatan belajar ini.');
        }

        $worksheet->load(['instructions' => function($q) use ($group) {
            $q->with(['answers' => function($q2) use ($group) {
                $q2->where('group_id', $group->id);
            }]);
        }]);

        $instructions = $worksheet->instructions->map(function($instruction) use ($group) {
            $instruction->group_answer = $instruction->answers->first();
            return $instruction;
        });

        return view($this->view . 'show', compact('worksheet', 'group', 'instructions'));
    }

    public function store(GroupAnswerRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->filled('id')
                ? GroupAnswer::findOrFail($request->id)
                : new GroupAnswer();

            $data->fill($request->validated());
            $data->save();

            DB::commit();

            session()->flash(
                'alert.answer.success',
                $request->has('id')
                    ? 'Jawaban berhasil diperbarui'
                    : 'Jawaban berhasil dikirim'
            );

            return back();

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.answer.error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}
