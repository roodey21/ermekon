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
        return [
            'name' => 'required|max:100',
            'manage_code' => 'required|boolean',
            // 'code' => 'required|max:100|unique:products,code',
            'unit_id' => 'required',
            // 'buy_price' => 'required|numeric',
            // 'supplier' => 'required|max:100'
            'category_id' => 'required|exists:categories,id',
            // 'description' => 'required',
            // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }
}
