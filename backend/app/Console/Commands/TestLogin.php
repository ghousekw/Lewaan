<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestLogin extends Command
{
    protected $signature = 'admin:test-login';
    protected $description = 'Test admin login credentials';

    public function handle()
    {
        $email = 'info@lewaninterior.com';
        $password = 'Lewan2025!';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        $this->info('User found:');
        $this->info('ID: ' . $user->id);
        $this->info('Email: ' . $user->email);
        $this->info('Name: ' . $user->name);
        $this->info('Password Hash: ' . $user->password);
        
        // Test password
        if (Hash::check($password, $user->password)) {
            $this->info('✓ Password check: SUCCESS');
        } else {
            $this->error('✗ Password check: FAILED');
        }

        // Test Auth attempt
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->info('✓ Auth attempt: SUCCESS');
        } else {
            $this->error('✗ Auth attempt: FAILED');
        }

        return 0;
    }
}
