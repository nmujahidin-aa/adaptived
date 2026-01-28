<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;

class GuideController extends Controller
{
    private $view;
    private $route;
    private $guide;

    public function __construct(){
        $this->view = 'pages.student.guide.';
        $this->route = 'student.guide.';
        $this->guide = new Guide();
    }

    public function index(){
        $data = $this->guide->first();
        return view($this->view . 'index', compact('data'));
    }
}
