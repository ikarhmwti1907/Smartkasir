<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'smartkasir25@gmail.com'], // jika sudah ada, update
            [
                'name' => 'Kasir',
                'password' => Hash::make('kasir_123'), // bebas ganti
            ]
        );
    }
}