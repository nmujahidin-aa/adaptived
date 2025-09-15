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

    public function show($id) {
        $assesment = Assesment::findOrFail($id);
        $data = \App\Models\Answer::where('assesment_id', $assesment->id)
            ->where('user_id', Auth::id())
            ->first();

        return view($this->view . 'show', [
            'assesment' => $assesment,
            'data' => $data
        ]);
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
