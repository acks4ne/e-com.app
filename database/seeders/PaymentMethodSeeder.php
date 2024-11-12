<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        PaymentMethod::factory()->createMany([
            [
                'name' => 'Наличные',
            ],
            [
                'name' => 'Банковская карта',
            ],
            [
                'name' => 'Бонусами'
            ]
        ]);
    }
}
