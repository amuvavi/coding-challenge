<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuotationRequest extends FormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'age' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $ages = explode(',', $value);
                    foreach ($ages as $age) {
                        if (!is_numeric(trim($age)) || (int)$age < 18 || (int)$age > 70) {
                            $fail('All ages must be between 18 and 70.');
                            return;
                        }
                    }
                },
            ],

            'currency_id' => ['required', 'string', Rule::in(['EUR', 'GBP', 'USD'])],
            'start_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }
}