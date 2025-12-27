<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {password=Lewan2025!}';
    protected $description = 'Reset admin user password';

    public function handle()
    {
        $user = User::where('email', 'info@lewaninterior.com')->first();

        if (!$user) {
            $this->error('Admin user not found!');
            return 1;
        }

        $password = $this->argument('password');
        $user->password = $password; // Laravel auto-hashes via 'hashed' cast
        $user->save();

        $this->info('Password reset successfully!');
        $this->info('Email: info@lewaninterior.com');
        $this->info('New Password: ' . $password);
        $this->info('Password hash: ' . $user->password);

        return 0;
    }
}
