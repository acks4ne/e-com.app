<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class BuyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_method_id' => ['required_without:payment_method_alias', 'integer', 'exists:payment_methods,id'],
            'payment_method_alias' => ['required_without:payment_method_id', 'integer', 'exists:payment_methods,alias'],
        ];
    }
}
