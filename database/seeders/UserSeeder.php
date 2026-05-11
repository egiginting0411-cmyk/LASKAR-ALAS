<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi.pratama@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12341234'),
            'role' => 'super',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12341234'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Citra Lestari',
            'email' => 'citra.lestari@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12341234'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dewi Anggraini',
            'email' => 'dewi.anggraini@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12341234'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Eko Saputra',
            'email' => 'eko.saputra@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12341234'),
            'role' => 'user',
        ]);
    }
}
