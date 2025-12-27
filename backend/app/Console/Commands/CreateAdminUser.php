<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create admin user for production';

    public function handle()
    {
        $user = User::firstOrCreate(
            ['email' => 'info@lewaninterior.com'],
            [
                'name' => 'Admin',
                'password' => 'admin123', // Laravel auto-hashes via 'hashed' cast
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->info('Admin user created successfully!');
            $this->info('Email: info@lewaninterior.com');
            $this->info('Password: admin123');
        } else {
            $this->info('Admin user already exists.');
            $this->info('Email: ' . $user->email);
        }

        return 0;
    }
}
