<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class CartProductFilterRequest extends IndexRequest
{
    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        parent::prepareForValidation();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules()
        );
    }
}
