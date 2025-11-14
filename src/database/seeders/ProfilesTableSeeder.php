<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
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
                'image_url' => 'user1.jpg',
            ],
            [
                'user_id' => 2,
                'post_code' => '200-0022',
                'address' => '東京都中野区新井1-2-3',
                'building' => '中野ビル203',
                'image_url' => 'user2.jpg',
            ],
            [
                'user_id' => 3,
                'post_code' => '300-0033',
                'address' => '東京都新宿区西新宿1-2-3',
                'building' => '西新宿ヒルズ303',
                'image_url' => 'user3.jpg',
            ],
        ]);
    }
}
