<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class InstructionRequest extends FormRequest
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
            'worksheet_id' => ['required', 'exists:worksheets,id'],
            'instruction-trixFields' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'worksheet_id.required' => 'Worksheet ID wajib diisi.',
            'worksheet_id.exists' => 'Worksheet ID yang dipilih tidak valid.',
        ];
    }
}
