<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // gunakan bcrypt
            'role' => 'admin',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir Satu',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);
    }
}
