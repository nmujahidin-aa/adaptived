<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Variable;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\DataTables\QuestionsDataTable;
use App\Http\Requests\Teacher\QuestionRequest;

class QuestionController extends Controller
{
    private $question;
    private $view;

    public function __construct(){
        $this->view = 'pages.teacher.questions.';
        $this->question = new Question();
    }

    public function index($variable_id, QuestionsDataTable $dataTable) {
        $variable = Variable::findOrFail($variable_id);
        $questions = $this->question->where('assesment_variable_id', $variable_id)->get();

        $question_count = $questions->count();

        return $dataTable->render($this->view . 'index', [
            'variable' => $variable,
            'questions' => $questions,
            'question_count' => $question_count
        ]);
    }

    public function edit(string $variable_id, string $id = null) {
        $variable = Variable::findOrFail($variable_id);
        if ($id) {
            $question = $this->question->findOrFail($id);
        }
        return view($this->view . 'edit', [
            'variable' => $variable,
            'question' => $question ?? null
        ]);
    }

    public function store(QuestionRequest $request) {
        $variable_id = $request->validated()['assesment_variable_id'];
        $variable = Variable::findOrFail($variable_id);

        if ($request->has('id') && $request->id) {
            $question = $this->question->findOrFail($request->id);
            $question->update($request->validated());
            
            session()->flash('alert.assesment.question.success', 'Data soal berhasil diperbarui');

            return redirect()->route('teacher.assesment.question.edit', [
                'variable_id' => $variable_id, 
                'question' => $question->id
            ]);
        } 
        else {
            $newQuestion = $this->question->create($request->validated());

            session()->flash('alert.assesment.question.success', 'Data soal berhasil ditambahkan');

            return redirect()->route('teacher.assesment.question.index', [
                'variable_id' => $variable_id
            ]);
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
            $assesment = Variable::find($id);
            if (!$assesment) {
                continue;
            }
            $assesment->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Question deleted successfully');
    }

    public function single_destroy() {
        $question = $this->question->findOrFail(request()->route('id'));

        if (!$question) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Question tidak ditemukan atau sudah dihapus');
        }
        $question->delete();
        session()->flash('alert.assesment.question.success', 'Question berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Question berhasil dihapus', [
            'redirect' => route('teacher.assesment.question.index')
        ]);
    }
}
