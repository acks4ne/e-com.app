<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
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
}
