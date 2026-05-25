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
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('bzqvcx'),
            'role' => 'owner',
        ]);
        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('qwerty'),
            'role' => 'supervisor',
        ]);
        User::create([
            'name' => 'Employee',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('zxcvb'),
            'role' => 'employee',
        ]);
    }
}
