<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Contracts\Role;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
            ],
            'school_id' => [
                'required',
                'exists:schools,id',
            ],
            'gender' => [
                'required',
                'in:L,P',
            ],
            'password' => [
                'required',
                'min:8',
            ],
            'role' => [
                'required',
                'in:TEACHER,STUDENT',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 255 karakter',
            'school_id.required' => 'Asal sekolah harus dipilih',
            'school_id.exists' => 'Asal sekolah tidak valid',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'gender.in' => 'Jenis kelamin tidak valid',
            'role.required' => 'Peran harus dipilih',
            'role.in' => 'Peran tidak valid',
        ];
    }

    
}
