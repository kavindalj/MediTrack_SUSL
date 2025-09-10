<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@meditrack.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_verified' => true,
        ]);
    }
}
