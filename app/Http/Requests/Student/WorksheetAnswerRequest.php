<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class WorksheetAnswerRequest extends FormRequest
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
            'worksheet_id' => 'required|exists:worksheets,id',
            'group_id' => 'required|exists:groups,id',
            'worksheet_instruction_id' => 'required|exists:worksheet_instructions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'answer-trixFields.required' => 'Jawaban harus diisi',
            'worksheet_id.required' => 'Worksheet wajib diisi',
            'worksheet_id.exists' => 'Worksheet yang dipilih tidak valid',
            'group_id.required' => 'Kelompok wajib diisi',
            'group_id.exists' => 'Kelompok yang dipilih tidak valid',
            'worksheet_instruction_id.required' => 'Instruksi wajib diisi',
            'worksheet_instruction_id.exists' => 'Instruksi yang dipilih tidak valid',
        ];
    }
}
