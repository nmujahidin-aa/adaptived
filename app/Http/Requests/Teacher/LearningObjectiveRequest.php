<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class LearningObjectiveRequest extends FormRequest
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
            'content' => 'nullable|string', 
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul Tujuan Pembelajaran wajib diisi.',
            'title.string' => 'Judul Tujuan Pembelajaran harus berupa teks.',
            'title.max' => 'Judul Tujuan Pembelajaran tidak boleh lebih dari 255 karakter.',
            'content.string' => 'Content harus berupa teks.',
        ];
    }
}
