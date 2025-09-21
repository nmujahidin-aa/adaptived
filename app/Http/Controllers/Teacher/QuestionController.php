<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Variable;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Teacher\QuestionRequest;
use App\DataTables\Teacher\QuestionsDataTable;
use Illuminate\Support\Facades\DB;  

class QuestionController extends Controller
{
    private $question;
    private $view;

    public function __construct(){
        $this->view = 'pages.teacher.questions.';
        $this->question = new Question();
    }

    public function index(QuestionsDataTable $dataTable, $assesment_id) {
        $question_count = Question::where('assesment_id', $assesment_id)->count();
        return $dataTable->with(['assesment_id' => $assesment_id])
        ->render($this->view.'index', [
            'assesment_id' => $assesment_id,
            'question_count' => $question_count,
        ]);
    }

    public function edit($assesment_id, string $id = null) {
        if ($id) {
            $data = Question::findOrFail($id);
        } else {
            $data = new Question();
            $data->assesment_id = $assesment_id;
        }

        return view($this->view . 'edit', [
            'data' => $data,
            'assesment_id' => $assesment_id,
        ]);
    }

    public function store(QuestionRequest $request) {
        DB::beginTransaction();
        try {
            $data = $request->filled('id')
                ? Question::findOrFail($request->id)
                : new Question();
            
            $data->fill($request->validated());

            $data->question = $request->input('question-trixFields.question', $data->question);

            $data->save();

            DB::commit();

            session()->flash(
                'alert.question.success',
                $request->has('id')
                    ? 'Data pertanyaan berhasil diperbarui'
                    : 'Data pertanyaan berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('teacher.question.edit', ['assesment_id' => $data->assesment_id, 'id' => $data->id])
                : redirect()->route('teacher.question.index', ['assesment_id' => $data->assesment_id]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.question.error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            $question = Question::find($id);
            if (!$question) {
                continue;
            }
            $question->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Question deleted successfully');
    }

    public function single_destroy() {
        $question = Question::findOrFail(request()->route('id'));

        if (!$question) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Question tidak ditemukan atau sudah dihapus');
        }
        $question->delete();
        session()->flash('alert.question.success', 'Question berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Question berhasil dihapus', [
            'redirect' => route('teacher.question.index', ['assesment_id' => $question->assesment_id])
        ]);
    } 
}
