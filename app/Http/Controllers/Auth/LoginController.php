<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Log;
use App\Enums\RoleEnum;
use App\Models\User;
use Error;

class LoginController extends Controller
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
        return view($this->view."login");
    }

    public function store(LoginRequest $request)
    {
        try {
            $email = $request->input("email") ? trim($request->input("email")) : null;
            $password = $request->input("password") ? trim($request->input("password")) : null;
            $rememberme = $request->filled('rememberme');

            $field = [
                'email' => $email,
                'password' => $password
            ];

            if (Auth::attempt($field, $rememberme)) {
                $user = Auth::user();

                if (!$user->hasRole([
                    RoleEnum::SUPERADMIN,
                    RoleEnum::ADMINISTRATOR,
                    RoleEnum::TEACHER,
                    RoleEnum::STUDENT,
                ])) {
                    Auth::logout();
                    throw new \Exception("Anda tidak diperbolehkan mengakses menu ini");
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Login berhasil',
                    'data' => [
                        'redirect' => route('dashboard.index')
                    ]
                ]);
            } else {
                throw new \Exception("Email atau password salah");
            }

        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json([
                'status' => 422,
                'message' => $e->getMessage()
            ], 422);
        }
    }


}
