<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric'],
            'is_pined' => ['sometimes', 'integer'],
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'frequency' => ['nullable', 'in:monthly,daily,weekly,yearly'],
        ];
    }
}
