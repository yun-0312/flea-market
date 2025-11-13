<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'email' => 'user1@test.com',
                'password' => Hash::make('testtest'),
            ],
            [
                'name' => '田中　花子',
                'email' => 'user2@test.com',
                'password' => Hash::make('testtest'),
            ],
            [
                'name' => '木村　次郎',
                'email' => 'user3@testtest.com',
                'password' => Hash::make('testtest'),
            ],
        ]);
    }
}
