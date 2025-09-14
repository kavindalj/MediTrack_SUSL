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
        // Create default pharmacist user
        User::create([
            'name' => 'Pharmacist User',
            'email' => 'pharmacist@meditrack.com',
            'password' => Hash::make('password123'),
            'role' => 'pharmacist',
            'is_verified' => true,
        ]);
    }
}
