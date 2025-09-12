<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class LearningResourceRequest extends FormRequest
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
            'short_description' => 'required|string',
            'learningresource-trixFields' => 'nullable',
            'attachment-learningresource-trixFields' => 'nullable',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'school_id' => 'required|exists:schools,id'
        ];
    }
}
