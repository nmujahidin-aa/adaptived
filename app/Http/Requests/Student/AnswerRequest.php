<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'answer-trixFields' => 'nullable',
            'attachment-answer-trixFields' => 'nullable',
            'assesment_id' => 'required|exists:assesments,id',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
