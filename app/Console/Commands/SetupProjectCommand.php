<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use PDO;

#[AsCommand(
    name: 'setup:project',
    description: 'Initialize the system: recreate the database, run migrations and insert a test user.'
)]
class SetupProjectCommand extends Command
{
    public function handle(): int
    {
        $dbName = Config::get('database.connections.mysql.database');
        $dbUser = Config::get('database.connections.mysql.username');
        $dbPass = Config::get('database.connections.mysql.password');
        $dbHost = Config::get('database.connections.mysql.host');

        // User confirmation
        if (! $this->confirm("Are you sure you want to recreate the database `{$dbName}`?")) {
            $this->warn('Task cancelled.');
            return self::SUCCESS;
        }

        // Create PDO connection to run DROP and CREATE
        try {
            $pdo = new PDO("mysql:host={$dbHost}", $dbUser, $dbPass);

            $pdo->exec("DROP DATABASE IF EXISTS `{$dbName}`;");
            $this->info("Database `{$dbName}` has been dropped.");

            $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $this->info("Database `{$dbName}` has been created.");
        } catch (\Exception $e) {
            $this->error("Error creating database: " . $e->getMessage());
            return self::FAILURE;
        }

        // Run migrations
        $this->info("Running migrations...");
        Artisan::call('migrate', ['--force' => true]);
        $this->info(Artisan::output());

        // Insert test user if it does not exist
        if (!User::where('email', 'pingo@gmail.com')->exists()) {
            User::create([
                'name' => 'Pinguito',
                'email' => 'pingo@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: pingo@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }

        $this->info("Project successfully initialized.");
        return self::SUCCESS;
    }
}