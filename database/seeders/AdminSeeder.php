<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'smartkasir25@gmail.com'],  // cek email dulu
            [
                'name' => 'Smartkasir',
                'username' => 'kasir',
                'avatar' => null, // atau path default
                'password' => Hash::make('kasir_123'),
            ]
        );
    }
}