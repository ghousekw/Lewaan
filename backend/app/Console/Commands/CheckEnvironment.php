<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CheckEnvironment extends Command
{
    protected $signature = 'check:env';
    protected $description = 'Check environment configuration';

    public function handle()
    {
        $this->info('=== ENVIRONMENT CHECK ===');
        
        $this->info("\n--- APP CONFIG ---");
        $this->line("APP_ENV: " . config('app.env'));
        $this->line("APP_DEBUG: " . (config('app.debug') ? 'true' : 'false'));
        $this->line("APP_URL: " . config('app.url'));
        $this->line("APP_KEY set: " . (config('app.key') ? 'YES' : 'NO'));
        
        $this->info("\n--- DATABASE CONFIG ---");
        $this->line("DB_CONNECTION: " . config('database.default'));
        
        $dbConfig = config('database.connections.' . config('database.default'));
        $this->line("DB_HOST: " . ($dbConfig['host'] ?? 'N/A'));
        $this->line("DB_PORT: " . ($dbConfig['port'] ?? 'N/A'));
        $this->line("DB_DATABASE: " . ($dbConfig['database'] ?? 'N/A'));
        $this->line("DB_USERNAME: " . ($dbConfig['username'] ?? 'N/A'));
        $this->line("DB_PASSWORD: " . (isset($dbConfig['password']) && $dbConfig['password'] ? 'SET (hidden)' : 'NOT SET'));
        
        $this->info("\n--- SESSION CONFIG ---");
        $this->line("SESSION_DRIVER: " . config('session.driver'));
        $this->line("SESSION_LIFETIME: " . config('session.lifetime'));
        $this->line("SESSION_COOKIE: " . config('session.cookie'));
        $this->line("SESSION_DOMAIN: " . (config('session.domain') ?: 'null'));
        $this->line("SESSION_SECURE: " . (config('session.secure') ? 'true' : 'false'));
        $this->line("SESSION_SAME_SITE: " . config('session.same_site'));
        
        $this->info("\n--- DATABASE CONNECTION TEST ---");
        try {
            $dbName = DB::connection()->getDatabaseName();
            $this->info("✓ Connected to database: $dbName");
            
            // Check if sessions table exists
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            $tableNames = array_column($tables, 'tablename');
            
            $this->info("\n--- TABLES IN DATABASE ---");
            foreach ($tableNames as $table) {
                $this->line("  - $table");
            }
            
            if (in_array('sessions', $tableNames)) {
                $sessionCount = DB::table('sessions')->count();
                $this->info("\n✓ Sessions table exists ($sessionCount records)");
            } else {
                $this->error("\n✗ Sessions table NOT FOUND!");
            }
            
            if (in_array('users', $tableNames)) {
                $userCount = DB::table('users')->count();
                $this->info("✓ Users table exists ($userCount users)");
                
                $users = DB::table('users')->select('id', 'email', 'name')->get();
                $this->info("\n--- USERS IN DATABASE ---");
                foreach ($users as $user) {
                    $this->line("  ID: {$user->id}, Email: {$user->email}, Name: {$user->name}");
                }
            } else {
                $this->error("✗ Users table NOT FOUND!");
            }
            
        } catch (\Exception $e) {
            $this->error("✗ Database connection FAILED!");
            $this->error("Error: " . $e->getMessage());
        }
        
        $this->info("\n--- RAW ENV VARIABLES ---");
        $this->line("DB_CONNECTION env: " . (env('DB_CONNECTION') ?: 'NOT SET'));
        $this->line("DB_HOST env: " . (env('DB_HOST') ?: 'NOT SET'));
        $this->line("DB_DATABASE env: " . (env('DB_DATABASE') ?: 'NOT SET'));
        $this->line("SESSION_DRIVER env: " . (env('SESSION_DRIVER') ?: 'NOT SET'));
        
        return 0;
    }
}
