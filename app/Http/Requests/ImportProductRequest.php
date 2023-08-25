<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File tidak boleh kosong.',
            'file.mimes' => 'Berikut tipe file yang diperbolehkan: xlsx, xls, csv.'
        ];
    }
}
