<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Teacher\AnswersDataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Assesment;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    protected $view;
    protected $route;
    protected $analysis;

    public function __construct(){
        $this->view = "pages.teacher.answer.";
        $this->route = "teacher.answer.";
        $this->analysis = new Answer();
    }

    public function index(AnswersDataTable $dataTable, $assesment_id)
    {
        $assesment_count = Answer::where('assesment_id', $assesment_id)->count();
        return $dataTable->with(['assesment_id' => $assesment_id])
        ->render($this->view.'index', [
            'assesment_id' => $assesment_id,
            'assesment_count' => $assesment_count,
        ]);
    }

    public function show($assesment_id, $id)
    {
        $assesment = Assesment::findOrFail($assesment_id);
        $data = Answer::findOrFail($id);

        return view($this->view . 'show', [
            'data' => $data,
            'assesment' => $assesment,
        ]);
    }
}
