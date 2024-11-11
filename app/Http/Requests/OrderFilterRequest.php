<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class OrderFilterRequest extends IndexRequest
{

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge([
            'order_by' => [
                ''
            ]
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ''
        ];
    }
}
