<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'unit_id' => 'required',
            'type_id' => 'required|exists:types,id',
            'conversion' => 'array',
            'variants' => 'array'
        ];

        if (!$this->input('manage_code')) {
            $rules['code'] = 'required|max:100|unique:products,code,' . $this->product->id;
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
            'type_id.required' => 'Tipe Produk harus diisi',
            'type_id.exists' => 'Tipe Produk tidak ditemukan',
            'code.required' => 'Kode harus diisi',
            'code.max' => 'Kode maksimal 100 karakter',
            'code.unique' => 'Kode sudah digunakan'
        ];
    }
}
