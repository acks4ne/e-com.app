<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasAlias
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (empty($model['alias'])) {
                $model['alias'] = str($model['name'])->slug('_')->upper();
            }
        });
    }
}
