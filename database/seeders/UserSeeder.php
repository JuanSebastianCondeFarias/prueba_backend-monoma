<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'username'  => 'tester',
                'password' => Hash::make('password'),
                'is_active' => true,
                'role' => 1,
                'last_login' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),

            ],
            [
                'username'  => 'tester1',
                'password' => Hash::make('password'),
                'is_active' => true,
                'role' => 2,
                'last_login' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        ]);
    }
}
