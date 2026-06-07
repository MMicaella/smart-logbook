<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'osmenacolleges@gmail.com'],
            [
                'name' => 'Nenita Marcos',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'department' => 'Administration',
                'status' => 'approved',
                'profile_photo' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}