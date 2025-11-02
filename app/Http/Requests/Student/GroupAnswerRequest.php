<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class GroupAnswerRequest extends FormRequest
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
            'group_id' => 'required|exists:groups,id',
            'worksheet_id' => 'required|exists:worksheets,id',
            'answer' => 'nullable|string',
            'worksheet_instruction_id'  => 'required|exists:worksheet_instructions,id',
            'groupanswer-trixFields.groupanswer' => 'nullable|string',
            'attachment-groupanswer-trixFields' => 'nullable',
        ];
    }
}
