<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'status' => $this['status']['name'],
            'payment_method' => $this['method']['name'],
            'price' => $this['price'],
            'products' => $this['data'],
        ];
    }
}
