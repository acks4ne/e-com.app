<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class IndexRequest extends BaseRequest
{
    /**
     * @var int
     */
    protected int $limit = 20;

    /**
     * @var int
     */
    protected int $page = 1;

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        $limit = $this->input('limit', $this->limit);

        $page = $this->input('page', $this->page);

        $this->merge([
            'limit' => $this->getNonNegativeValue($limit, $this->limit),
            'page' => $this->getNonNegativeValue($page, $this->page),
        ]);
    }

    /**
     * @param mixed $value
     * @param int   $default
     * @return int
     */
    protected function getNonNegativeValue(mixed $value, int $default): int
    {
        return (is_numeric($value) && (int) $value > 0) ? (int) $value : $default;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'int'],
            'limit' => ['nullable', 'int'],
        ];
    }
}
