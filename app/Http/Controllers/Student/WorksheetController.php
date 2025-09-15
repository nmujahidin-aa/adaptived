<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorksheetController extends Controller
{
    protected $view;
    protected $route;

    public function __construct(){
        $this->route = 'worksheet.';
        $this->view = 'pages.student.worksheet.';
    }

    public function index(){
        return view($this->view . 'index');
    }

    public function show($id){
        return view($this->view . 'show', compact('id'));
    }
}
