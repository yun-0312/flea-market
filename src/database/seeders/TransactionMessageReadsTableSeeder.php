<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionMessageReadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_message_reads')->insert([
            [
                'transaction_message_id' => 1,
                'user_id' => 1,
                'read_at' => '2026-01-01 10:00:00',
            ],
            [
                'transaction_message_id' => 2,
                'user_id' => 1,
                'read_at' => '2026-01-01 10:00:00',
            ],
            [
                'transaction_message_id' => 4,
                'user_id' => 2,
                'read_at' => '2026-01-02 10:00:00',
            ],
            [
                'transaction_message_id' => 6,
                'user_id' => 1,
                'read_at' => '2026-01-02 10:20:00',
            ],
        ]);
    }
}
