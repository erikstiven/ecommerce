<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_items')->insert([
            ['order_id' => 1, 'product_id' => 1,  'quantity' => 50, 'price' => 15.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'product_id' => 2,  'quantity' => 40, 'price' => 20.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 3, 'product_id' => 3,  'quantity' => 35, 'price' => 12.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 4, 'product_id' => 4,  'quantity' => 30, 'price' => 25.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 5, 'product_id' => 5,  'quantity' => 28, 'price' => 18.50, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 6, 'product_id' => 6,  'quantity' => 25, 'price' => 22.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 7, 'product_id' => 7,  'quantity' => 20, 'price' => 30.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 8, 'product_id' => 8,  'quantity' => 18, 'price' => 11.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 9, 'product_id' => 9,  'quantity' => 15, 'price' => 19.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 10,'product_id' => 10, 'quantity' => 12, 'price' => 21.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 11,'product_id' => 11, 'quantity' => 10, 'price' => 17.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 12,'product_id' => 12, 'quantity' => 8,  'price' => 14.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 13,'product_id' => 13, 'quantity' => 6,  'price' => 16.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 14,'product_id' => 14, 'quantity' => 5,  'price' => 23.00, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 15,'product_id' => 15, 'quantity' => 3,  'price' => 28.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

