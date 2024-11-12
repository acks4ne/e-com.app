<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProductInCartRequest extends BaseRequest
{
    /**
     * @var int
     */
    protected int $quantity = 0;

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        $quantity = $this->input('quantity', $this->quantity);

        $this->merge([
            'quantity' => $this->getNonNegativeValue($quantity, $this->quantity),
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
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
        ];
    }
}
