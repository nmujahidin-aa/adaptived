<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class AssesmentRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'variable_id' => 'required|exists:variables,id',
            'school_id' => 'required|exists:schools,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'variable_id.required' => 'Variabel wajib diisi.',
            'variable_id.exists' => 'Variabel yang dipilih tidak valid.',
            'school_id.required' => 'Sekolah wajib diisi.',
            'school_id.exists' => 'Sekolah yang dipilih tidak valid.',
        ];
    }
}
