<?php

namespace App\Models;

use App\Traits\HasAlias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory, HasAlias;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'alias'
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
