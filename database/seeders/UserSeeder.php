<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_id'   => 'User0001',
            'dept_id'   => 'Dept0001',
            'username'  => 'Admin',
            'fullname'  => 'Rafael Bani',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('password123'),
        ]);

        User::create([
            'user_id'   => 'User0002',
            'dept_id'   => 'Dept0002',
            'username'  => 'Tasia',
            'fullname'  => 'Anastasia Liem', 
            'email'     => 'tasia@example.com',
            'password'  => Hash::make('password123'),
        ]);

        User::create([
            'user_id'   => 'User0003',
            'dept_id'   => 'Dept0003',
            'username'  => 'Zaidan',
            'fullname'  => 'Muhammad Zaidan', 
            'email'     => 'zaidan@example.com',
            'password'  => Hash::make('password123'),
        ]);


        User::create([
            'user_id'   => 'User0004',
            'dept_id'   => 'Dept0004',
            'username'  => 'Bryan',
            'fullname'  => 'Bryan Nathaniel', 
            'email'     => 'bryan@example.com',
            'password'  => Hash::make('password123'),
        ]);


        User::create([
            'user_id'   => 'User0005',
            'dept_id'   => 'Dept0002',
            'username'  => 'Go Yoonjung',
            'fullname'  => 'Go Yoon-Jung', 
            'email'     => 'gyj@example.com',
            'password'  => Hash::make('password123'),
        ]);
    }
}
