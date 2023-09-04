<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'package_id' => 'nullable|integer|exists:packages,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status_id' => 'nullable|integer|exists:statuses,id',
        ];
    }
}
