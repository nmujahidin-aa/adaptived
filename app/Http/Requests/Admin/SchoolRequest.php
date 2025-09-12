<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'short_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama variabel harus diisi',
            'name.string' => 'Nama variabel harus berupa teks',
            'name.max' => 'Nama variabel tidak boleh lebih dari 255 karakter',
            'short_name.required' => 'Nama singkat harus diisi',
            'short_name.string' => 'Nama singkat harus berupa teks',
            'short_name.max' => 'Nama singkat tidak boleh lebih dari 255 karakter',
            'address.string' => 'Alamat harus berupa teks',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter',
            'phone.max' => 'Telepon tidak boleh lebih dari 255 karakter',
            'website.max' => 'Website tidak boleh lebih dari 255 karakter',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.max' => 'Logo tidak boleh lebih dari 2048 kilobyte',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status tidak valid',
        ];
    }
}
