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
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@mlhk.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        // Client Admin (Store Owner)
        User::create([
            'name' => 'Client Admin',
            'email' => 'client@store.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer
        User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
