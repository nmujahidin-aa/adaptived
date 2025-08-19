<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variable;

class AssesmentController extends Controller
{
    private $view;
    private $assesment;

    public function __construct(){
        $this->view = 'pages.student.assesment.';
        $this->assesment = new Variable();
    }

    public function index(){
        $assesment = $this->assesment::all();
        return view($this->view . 'index', [
            'assesment' => $assesment,
        ]);
    }

    public function questionsIndex(string $assesment_id){
        $questions = $this->assesment->findOrFail($assesment_id)->questions;
        $assesment = $this->assesment::findOrFail($assesment_id);
        return view($this->view . 'questions', [
            'assesment' => $assesment,
        ]);
    }
}
