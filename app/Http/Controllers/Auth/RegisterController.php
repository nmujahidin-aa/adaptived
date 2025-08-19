<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private $view;
    public function __construct()
    {
        $this->view = "pages.auth.";
    }
    public function index(){
        if(Auth::check()){
            return redirect()->route('dashboard.index');
        }
        return view($this->view."register");
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Registrasi berhasil. Silakan login',
            'redirect' => route('auth.login.index'),
        ]);
    }
}
