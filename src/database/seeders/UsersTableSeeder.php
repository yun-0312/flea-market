<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => '鈴木　一郎',
                'email' => 'test@test.com',
                'email_verified_at' => '2025-11-01',
            ],
        ]);
    }
}
