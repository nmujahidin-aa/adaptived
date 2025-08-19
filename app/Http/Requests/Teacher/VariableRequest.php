<?php

namespace App\Http\Requests\Teacher;

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
            'icon' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama variabel harus diisi',
            'name.string' => 'Nama variabel harus berupa teks',
            'name.max' => 'Nama variabel tidak boleh lebih dari 255 karakter',
            'icon.string' => 'Ikon harus berupa teks',
            'icon.max' => 'Ikon tidak boleh lebih dari 255 karakter',
        ];
    }
}
