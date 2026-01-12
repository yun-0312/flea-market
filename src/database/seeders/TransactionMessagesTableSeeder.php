<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_messages')->insert([
            [
                'transaction_id' => 1,
                'user_id' => 2,
                'message' => 'できるだけ早くほしいのですが、いつ発送できますか？',
                'created_at' => '2026-01-01 09:30:00',
            ],
            [
                'transaction_id' => 1,
                'user_id' => 2,
                'message' => '可能であれば今週の週末までに欲しいです。',
                'created_at' => '2026-01-01 09:35:00',
            ],
            [
                'transaction_id' => 1,
                'user_id' => 1,
                'message' => '明日発送できます。',
                'created_at' => '2026-01-01 10:00:00',
            ],
            [
                'transaction_id' => 3,
                'user_id' => 3,
                'message' => '商品を購入させていただきました。短い間ですがお取引よろしくお願いいたします。',
                'created_at' => '2026-01-02 09:30:00',
            ],
            [
                'transaction_id' => 3,
                'user_id' => 1,
                'message' => '購入いただきありがとうございます。こちらこそどうぞよろしくお願いします。',
                'created_at' => '2026-01-02 10:00:00',
            ],
            [
                'transaction_id' => 3,
                'user_id' => 1,
                'message' => '明日には発送予定です。',
                'created_at' => '2026-01-02 10:30:00',
            ],
            [
                'transaction_id' => 3,
                'user_id' => 3,
                'message' => '発送状況はいかがでしょうか？',
                'created_at' => '2026-01-02 10:20:00',
            ],
                        [
                'transaction_id' => 3,
                'user_id' => 3,
                'message' => '明後日までに発送できないならキャンセルしたいです。',
                'created_at' => '2026-01-02 10:21:00',
            ],
            [
                'transaction_id' => 1,
                'user_id' => 2,
                'message' => 'ありがとうございます！商品の到着を楽しみにしています。',
                'created_at' => '2026-01-01 10:30:00',
            ],
        ]);
    }
}