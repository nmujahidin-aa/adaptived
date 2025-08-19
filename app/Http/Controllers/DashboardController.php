<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    private $view;
    private $route;
    private $user;

    public function __construct(){
        $this->view = "pages.dashboard.";
        $this->route = "dashboard";
        $this->user = new User();
    }
    public function index()
    {
        $user = $this->user->find(\Illuminate\Support\Facades\Auth::id());
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect()->route('auth.login.index');
        }
        return view($this->view . 'index', [
            'user' => $user,
        ]);
    }
}
