<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'user_id' => 1,
                'post_code' => '100-0011',
                'address' => '東京都豊島区西池袋1-2-3',
                'building' => '池袋マンション301',
            ],
            [
                'user_id' => 1,
                'post_code' => '400-0044',
                'address' => '東京都板橋区板橋1-2-3',
                'building' => '板橋ビル501',
            ],
            [
                'user_id' => 2,
                'post_code' => '200-0022',
                'address' => '東京都中野区新井1-2-3',
                'building' => '中野ビル203',
            ],
        ]);
    }
}
