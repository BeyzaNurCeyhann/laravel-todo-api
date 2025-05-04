<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'due_date' => ['required', 'date', 'after:today'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id']
        ];
    }
}
