<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionStoreRequest extends FormRequest
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
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'budget_id' => ['nullable', 'integer','exists:budgets,id'],

            'trx_year' => ['required', 'date_format:Y'],
            'trx_month' => ['required', 'date_format:m'],
            'trx_month' => ['sometimes', 'numeric', 'between:0,99999999.99'],

            'cash_amount' => ['sometimes', 'numeric', 'between:0,99999999.99'],
            'cash_trx_type' => [ Rule::requiredIf($this->cash_amount > 0),'nullable', 'in:debit,credit'],
            
            'bank_amount' => ['sometimes', 'numeric', 'between:0,99999999.99'],
            'bank_trx_type' => [Rule::requiredIf($this->bank_amount > 0),'nullable', 'in:debit,credit'],
        ];
    }
}
