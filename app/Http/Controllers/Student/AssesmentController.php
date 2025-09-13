<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assesment;

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

        return view($this->view . 'show', [
            'assesment' => $assesment
        ]);
    }

}
