<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Enums\RoleEnum;

class RegisterController extends Controller
{
    private $view;
    private $school;

    public function __construct()
    {
        $this->view = "pages.auth.";
        $this->school = new \App\Models\School();
    }
    public function index(){
        if(Auth::check()){
            return redirect()->route('dashboard.index');
        }
        $school = $this->school::all();

        return view($this->view."register",[
            'school' => $school,
        ]);
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'name'     => $data['name'],
            'gender'   => $data['gender'],
            'school_id'=> $data['school_id'],
        ]);
        $user->assignRole($data['role']);

        alert()->html('Berhasil', 'Akun berhasil dibuat, silahkan login', 'success');
        return redirect()->route('auth.login.index');
    }
}
