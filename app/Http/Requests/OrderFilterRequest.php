<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Ramsey\Collection\Sort;

class OrderFilterRequest extends IndexRequest
{
    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $orderStatusId = $this->getNonNegativeValue($this->input('filter.order_status_id'), 0);

        $this->merge([
            'order_by' => [
                'created_at' => Sort::tryFrom($this->input('order_by.created_at'))?->value ?? Sort::Descending->value
            ],
            'filter' => [
                'order_status_id' => $orderStatusId === 0 ? null : $orderStatusId,
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
        return [
            'order_by' => ['nullable', 'array'],
            'order_by.created_at' => [Rule::in(Sort::cases())],
            'filter' => ['nullable', 'array'],
            'filter.order_status_id' => ['nullable', 'integer', 'exists:order_statuses,id']
        ];
    }
}
