<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'data',
        'payment_id',
        'order_status_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'data' => AsArrayObject::class,
    ];

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * @return BelongsTo
     */
    public function method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
