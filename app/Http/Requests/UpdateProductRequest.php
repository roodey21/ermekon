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
            'category_id' => 'required|exists:categories,id',
            'conversion' => 'array',
            'variants' => 'array'
        ];

        if (!$this->input('manage_code')) {
            $rules['code'] = 'required|max:100|unique:products,code,' . $this->product->id;
        }

        return $rules;
    }
}
