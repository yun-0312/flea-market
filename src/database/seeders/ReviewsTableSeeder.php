<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            [
                'transaction_id' => 2,
                'reviewer_id' => 2,
                'reviewee_id' => 1,
                'rating' => 5,
            ],
                        [
                'transaction_id' => 2,
                'reviewer_id' => 1,
                'reviewee_id' => 2,
                'rating' => 5,
            ],
        ]);
    }
}
