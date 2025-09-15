<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'leader_id' => 'required|exists:users,id',
            'member_id' => 'required|array',
            'member_id.*' => 'exists:users,id',
            'worksheet_id' => 'required|exists:worksheets,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kelompok wajib diisi.',
            'name.max' => 'Nama kelompok tidak boleh lebih dari 255 karakter.',
            'leader_id.required' => 'Ketua kelompok wajib dipilih.',
            'leader_id.exists' => 'Ketua yang dipilih tidak valid.',
            'member_id.required' => 'Anggota kelompok wajib dipilih.',
            'member_id.array' => 'Anggota kelompok harus dalam format yang benar.',
            'member_id.*.exists' => 'Salah satu anggota yang dipilih tidak valid.',
            'worksheet_id.required' => 'Kegiatan belajar wajib dipilih.',
            'worksheet_id.exists' => 'Kegiatan belajar yang dipilih tidak valid.',
        ];
    }
}
