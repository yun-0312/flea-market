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
                'email' => 'test@test.com',
                'password' => Hash::make('testtest'),
            ],
            [
                'name' => '田中　花子',
                'email' => 'testtest@test.com',
                'password' => Hash::make('testtest'),
            ],
            [
                'name' => '木村　次郎',
                'email' => 'test@testtest.com',
                'password' => Hash::make('testtest'),
            ],
        ]);
    }
}
