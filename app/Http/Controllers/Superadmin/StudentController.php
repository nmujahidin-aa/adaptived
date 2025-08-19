<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $view;
    private $route;

    public function __construct()
    {
        $this->view = "pages.superadmin.student.";
        $this->route = "superadmin.student";
    }

    public function index()
    {
        return view($this->view . 'index');
    }

}
