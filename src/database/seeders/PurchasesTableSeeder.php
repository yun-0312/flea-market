<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchases')->insert([
            [
                'user_id' => 2,
                'item_id' => 5,
                'shipping_address_id' => 1,
                'payment_method' => 1,
            ],
            [
                'user_id' => 2,
                'item_id' => 3,
                'shipping_address_id' => 2,
                'payment_method' => 2,
            ],
            [
                'user_id' => 3,
                'item_id' => 4,
                'shipping_address_id' => 3,
                'payment_method' => 1,
            ],
            [
                'user_id' => 1,
                'item_id' => 6,
                'shipping_address_id' => 5,
                'payment_method' => 1,
            ],
            [
                'user_id' => 2,
                'item_id' => 2,
                'shipping_address_id' => 4,
                'payment_method' => 1,
            ],
        ]);
    }
}
