<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DebugAuth extends Command
{
    protected $signature = 'debug:auth {--create : Create a new test user}';
    protected $description = 'Debug authentication issues';

    public function handle()
    {
        $password = 'Lewan2025!';

        // Create new user if --create flag is passed
        if ($this->option('create')) {
            return $this->createNewUser();
        }

        $email = 'info@lewaninterior.com';

        $this->info('=== DATABASE CONNECTION ===');
        try {
            $dbName = DB::connection()->getDatabaseName();
            $this->info("Connected to: $dbName");
        } catch (\Exception $e) {
            $this->error("DB Error: " . $e->getMessage());
            return 1;
        }

        $this->info("\n=== USER CHECK ===");
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User NOT found with email: $email");
            $this->info("\nAll users in database:");
            $allUsers = User::all(['id', 'email', 'name']);
            foreach ($allUsers as $u) {
                $this->line("  ID: {$u->id}, Email: {$u->email}, Name: {$u->name}");
            }
            return 1;
        }

        $this->info("User found - ID: {$user->id}");
        $this->info("Email: {$user->email}");
        $this->info("Name: {$user->name}");
        $this->info("Password hash length: " . strlen($user->password));
        $this->info("Password hash starts with: " . substr($user->password, 0, 10) . "...");

        $this->info("\n=== PASSWORD VERIFICATION ===");
        
        // Direct hash check
        $hashCheck = Hash::check($password, $user->password);
        $this->line("Hash::check('$password', hash): " . ($hashCheck ? 'TRUE' : 'FALSE'));

        // Check if password looks double-hashed (bcrypt hashes are 60 chars)
        if (strlen($user->password) > 60) {
            $this->warn("WARNING: Password hash is longer than 60 chars - might be double hashed!");
        }

        // Check hash format
        if (str_starts_with($user->password, '$2y$')) {
            $this->info("Hash format: bcrypt (correct)");
        } else {
            $this->error("Hash format: UNKNOWN - not bcrypt!");
        }

        $this->info("\n=== FIX ATTEMPT ===");
        $this->info("Creating fresh password hash...");
        
        // Bypass the model's hashed cast by using DB directly
        $freshHash = Hash::make($password);
        $this->info("New hash: " . substr($freshHash, 0, 20) . "...");
        
        DB::table('users')
            ->where('email', $email)
            ->update(['password' => $freshHash]);
        
        $this->info("Password updated directly via DB query (bypassing model cast)");

        // Verify the fix
        $user->refresh();
        $this->info("\n=== VERIFICATION AFTER FIX ===");
        $this->info("New hash length: " . strlen($user->password));
        
        $newHashCheck = Hash::check($password, $user->password);
        $this->line("Hash::check after fix: " . ($newHashCheck ? 'TRUE ✓' : 'FALSE ✗'));

        // Test Auth::attempt
        $authAttempt = Auth::attempt(['email' => $email, 'password' => $password]);
        $this->line("Auth::attempt after fix: " . ($authAttempt ? 'TRUE ✓' : 'FALSE ✗'));

        if ($newHashCheck && $authAttempt) {
            $this->info("\n✓ Authentication should now work!");
        } else {
            $this->error("\n✗ Still failing - there may be another issue");
        }

        return 0;
    }

    private function createNewUser()
    {
        $email = 'gmshaik.kw@gmail.com';
        $password = 'Lewan2025!';

        $this->info('=== CREATING NEW USER ===');

        // Check if user already exists
        $existing = User::where('email', $email)->first();
        if ($existing) {
            $this->warn("User already exists with email: $email");
            $this->info("Deleting existing user...");
            $existing->delete();
        }

        // Create user directly via DB to bypass model cast
        $hash = Hash::make($password);
        
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => $email,
            'password' => $hash,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->info("User created!");
        $this->info("Email: $email");
        $this->info("Password: $password");
        $this->info("Hash: " . substr($hash, 0, 20) . "...");

        // Verify
        $user = User::where('email', $email)->first();
        $hashCheck = Hash::check($password, $user->password);
        $authCheck = Auth::attempt(['email' => $email, 'password' => $password]);

        $this->info("\n=== VERIFICATION ===");
        $this->line("Hash::check: " . ($hashCheck ? 'TRUE ✓' : 'FALSE ✗'));
        $this->line("Auth::attempt: " . ($authCheck ? 'TRUE ✓' : 'FALSE ✗'));

        if ($hashCheck && $authCheck) {
            $this->info("\n✓ New user ready! You can now login.");
        } else {
            $this->error("\n✗ Something is still wrong.");
        }

        return 0;
    }
}
