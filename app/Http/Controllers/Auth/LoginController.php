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

            $email = (empty($request->input("email"))) ? null : trim(htmlentities($request->input("email")));
            $password = (empty($request->input("password"))) ? null : trim(htmlentities($request->input("password")));

            $rememberme = (empty($request->input('rememberme'))) ? false : true;

            $field = [
                'email' => $email,
                'password' => $password
            ];

            if (Auth::attempt($field, $rememberme)) {
                $user = Auth::user();

                // Cek apakah user memiliki salah satu role yang diizinkan
                if (!$user->hasRole([
                    RoleEnum::SUPERADMIN,
                    RoleEnum::ADMINISTRATOR,
                    RoleEnum::TEACHER,
                    RoleEnum::STUDENT,
                ])) {
                    Auth::logout();
                    throw new Error("Anda tidak diperbolehkan mengakses menu ini");
                }

                alert()->html('Berhasil', 'Login berhasil', 'success');
                return redirect()->intended(route('dashboard.index'));

            } else {
                throw new \Exception("Username atau password salah");
            }
        } catch (\Throwable $e) {
            Log::emergency($e->getMessage());

            alert()->html('Gagal',$e->getMessage(),'error');
            return redirect()->back()->withInput();
        }
    }

}
