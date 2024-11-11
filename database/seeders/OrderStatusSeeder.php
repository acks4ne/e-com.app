<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::factory()->createMany([
            [
                'name' => 'На оплату'
            ],
            [
                'name' => 'Оплачен',
            ],
            [
                'name' => 'Отменен'
            ],
        ]);
    }
}
