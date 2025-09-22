<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assesment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Http\Requests\Student\AnswerRequest;

class AssesmentController extends Controller
{
    private $view;
    private $assesment;

    public function __construct(){
        $this->view = 'pages.student.assesment.';
        $this->assesment = new Assesment();
    }

    public function index(){
        $assesment_count = 0;
        $assesment = $this->assesment::all();
        return view($this->view . 'index', [
            'assesment' => $assesment,
            'assesment_count' => $assesment_count,
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();

        $assesment = Assesment::findOrFail($id);

        $assesment->load(['questions' => function($q) use ($user) {
            $q->with(['answers' => function($q2) use ($user) {
                $q2->where('user_id', $user->id);
            }]);
        }]);
        $questions = $assesment->questions->map(function($question) {
            $question->user_answer = $question->answers->first();
            return $question;
        });

        return view($this->view . 'show', compact('assesment', 'questions'));
    }

    

    public function storeAnswer(AnswerRequest $request, $id)
    {
        try {
            $validated = $request->validated();

            $answerText = $request->input('answer');

            $answer = Answer::updateOrCreate(
                [
                    'assesment_id' => $validated['assesment_id'],
                    'user_id'      => $validated['user_id'],
                ],
                [
                    'answer' => $answerText,
                ]
            );

            session()->flash(
                'alert.assesment.success',
                $request->has('id')
                    ? 'Jawaban berhasil diperbarui'
                    : 'Jawaban berhasil dikirim'
            );

            return redirect()->route('assesment.show', $id);

        } catch (\Throwable $e) {
            report($e);
            session()->flash('alert.assesment.error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

}
