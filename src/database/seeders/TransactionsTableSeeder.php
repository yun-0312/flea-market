<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'purchase_id' => 1,
                'status' => 'trading',
            ],
            [
                'purchase_id' => 2,
                'status' => 'completed',
            ],
            [
                'purchase_id' => 3,
                'status' => 'trading',
            ],
            [
                'purchase_id' => 4,
                'status' => 'trading',
            ],
        ]);
    }
}