<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Ramsey\Collection\Sort;

class ProductFilterRequest extends IndexRequest
{
    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        parent::prepareForValidation();
        
        $this->merge([
            'order_by' => [
                'price' => Sort::tryFrom($this->input('order_by.price'))?->value ?? Sort::Descending->value,
            ]
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(), [
            'order_by' => ['nullable', 'array'],
            'order_by.price' => [Rule::in(Sort::cases())],
        ]);
    }
}
