<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorksheetRequest extends FormRequest
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
            'school_id' => 'required|exists:schools,id',
            'teacher_id' => 'required|exists:users,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'school_id.required' => 'Sekolah wajib dipilih.',
            'school_id.exists' => 'Sekolah yang dipilih tidak valid.',
            'cover.image' => 'Cover harus berupa file gambar.',
            'cover.mimes' => 'Cover harus berupa file dengan format: jpeg, png, jpg, gif, svg.',
            'cover.max' => 'Ukuran cover maksimal 5MB.',
        ];
    }
}
