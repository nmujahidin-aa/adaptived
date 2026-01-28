<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningObjective;
use App\Enums\RoleEnum;
use App\DataTables\Teacher\LearningObjectivesDataTable;
use App\Http\Requests\Teacher\LearningObjectiveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;

class LearningObjectiveController extends Controller
{
    private $view;
    private $route;
    private $learningObjective;

    public function __construct(){
        $this->view = "pages.teacher.learning-objective.";
        $this->route = "teacher.learning-objective.";
        $this->learningObjective = new LearningObjective();
    }

    public function index(LearningObjectivesDataTable $dataTable) {
        $teacher = Auth::user();
        $learningObjective = $this->learningObjective->where('school_id', $teacher->school_id);
        $learningObjective_count = $learningObjective->count();
        return $dataTable->render($this->view . 'index', [
            'learningObjective_count' => $learningObjective_count,
        ]);
    }

    public function edit(string $id = null) {
        $data = null;
        $school = \App\Models\School::all();
        if ($id) {
            $data = $this->learningObjective::where('school_id', auth()->user()->school_id)->findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data,
            'school' => $school
        ]);
    }

    public function store(LearningObjectiveRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->has('id')
                ? LearningObjective::findOrFail($request->id)
                : new LearningObjective();

            
            $data->fill($request->validated());
            $school_id = Auth::user()->school_id;
            $data->school_id = $school_id;

            $content = $request->input('learningobjective-trixFields.content');

            $data->content = $content;
            $data->save();

            DB::commit();

            session()->flash(
                'alert.learning_objective.success',
                $request->has('id')
                    ? 'Data tujuan pembelajaran berhasil diperbarui'
                    : 'Data tujuan pembelajaran berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('teacher.learning-objective.edit', $data->id)
                : redirect()->route('teacher.learning-objective.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.learning_objective.error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy() {
        $ids = request()->input('ids');
        if (!$ids) {
            return HttpResponse::fail(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid payload', [
                'ids' => ['Ids harus diisi']
            ]);
        }

        if (!is_array($ids)) {
            return HttpResponse::fail(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid payload', [
                'ids' => ['Ids harus berupa array']
            ]);
        }

        foreach ($ids as $id) {
            $learning_objective = $this->learningObjective->find($id);
            if (!$learning_objective) {
                continue;
            }
            $learning_objective->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Sumber belajar berhasil dihapus');
    }

    public function single_destroy() {
        $learning_objective = $this->learningObjective->findOrFail(request()->route('id'));

        if (!$learning_objective) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Sumber belajar tidak ditemukan atau sudah dihapus');
        }
        $learning_objective->delete();
        session()->flash('alert.learning_objective.success', 'Sumber belajar berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Sumber belajar berhasil dihapus', [
            'redirect' => route('teacher.learning-objective.index')
        ]);
    }
}
