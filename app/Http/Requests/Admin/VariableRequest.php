<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VariableRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama variabel harus diisi.',
            'icon.required' => 'Ikon variabel harus diisi.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
            'status.required' => 'Status variabel harus dipilih.',
            'status.in' => 'Status variabel tidak valid.',
        ];
    }
}
