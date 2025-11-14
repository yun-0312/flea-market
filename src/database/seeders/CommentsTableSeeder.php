<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'comment' => 'まだ売ってますか？',
                'user_id' => 1,
                'item_id' => 1,
            ],
            [
                'comment' => '安いですね！購入希望です。',
                'user_id' => 1,
                'item_id' => 8,
            ],
            [
                'comment' => '気になってます。詳細教えてください。',
                'user_id' => 2,
                'item_id' => 1,
            ],
            [
                'comment' => '美味しそうですね。',
                'user_id' => 2,
                'item_id' => 3,
            ],
            [
                'comment' => 'サイズを教えてください。',
                'user_id' => 3,
                'item_id' => 1,
            ],
            [
                'comment' => 'いつ頃購入しましたか？また、スペックを教えてください。',
                'user_id' => 3,
                'item_id' => 5,
            ],
        ]);
    }
}
