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
        // Create admin user for production
        User::firstOrCreate(
            ['email' => 'info@lewaninterior.com'],
            [
                'name' => 'Admin',
                'password' => 'admin123', // Laravel auto-hashes via 'hashed' cast - Change after first login!
            ]
        );
    }
}
