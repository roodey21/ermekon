<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:100',
            'manage_code' => 'boolean',
            'unit_id' => 'required|exists:units,id',
            'category_id' => 'required|exists:categories,id',
            'conversion_id' => 'array',
            'conversion_factor' => 'array'
        ];

        if ($this->input('manage_code')) {
            // $rules['code'] = 'max:100|unique:products,code';
        } else {
            $rules['code'] = 'required|max:100|unique:products,code';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama produk harus diisi',
            'name.max' => 'Nama produk maksimal 100 karakter',
            'manage_code.boolean' => 'Manage code harus berupa boolean',
            'unit_id.required' => 'Satuan harus diisi',
            'unit_id.exists' => 'Satuan tidak ditemukan',
            'category_id.required' => 'Kategori harus diisi',
            'category_id.exists' => 'Kategori tidak ditemukan',
            'conversion_id.array' => 'Konversi harus berupa array',
            'conversion_factor.array' => 'Konversi harus berupa array',
            'code.required' => 'Kode harus diisi',
            'code.max' => 'Kode maksimal 100 karakter',
            'code.unique' => 'Kode sudah digunakan'
        ];
    }
}
