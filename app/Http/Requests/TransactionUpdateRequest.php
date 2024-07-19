<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
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
            'category_id' => ['required', 'integer'],
            'budget_id' => ['nullable', 'integer'],

            'cash_amount' => ['sometimes', 'numeric', 'between:-99999999.99,99999999.99'],
            'bank_amount' => ['sometimes', 'numeric', 'between:-99999999.99,99999999.99'],

        ];
    }
}
