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
                'name' => 'Alexander Pingo',
                'email' => 'pingo@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: pingo@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }

        // Insert test user if it does not exist
        if (!User::where('email', 'pinga@gmail.com')->exists()) {
            User::create([
                'name' => 'Manuela Pinga',
                'email' => 'pinga@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: pinga@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }

        // Insert test user if it does not exist
        if (!User::where('email', 'joel@gmail.com')->exists()) {
            User::create([
                'name' => 'Joel Jimenez',
                'email' => 'joel@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: joel@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }        

        // Insert test user if it does not exist
        if (!User::where('email', 'kiara@gmail.com')->exists()) {
            User::create([
                'name' => 'Yunikua',
                'email' => 'kiara@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: kiara@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }  

        // Insert test user if it does not exist
        if (!User::where('email', 'misari@gmail.com')->exists()) {
            User::create([
                'name' => 'Tayron Misari',
                'email' => 'misari@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: misari@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }     
        
        // Insert test user if it does not exist
        if (!User::where('email', 'yasumy@gmail.com')->exists()) {
            User::create([
                'name' => 'Yasumy Pastor',
                'email' => 'yasumy@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: yasumy@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }            

        // Insert test user if it does not exist
        if (!User::where('email', 'nerio@gmail.com')->exists()) {
            User::create([
                'name' => 'Nerio Vasquez',
                'email' => 'nerio@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: nerio@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }   
        
        // Insert test user if it does not exist
        if (!User::where('email', 'jhon@gmail.com')->exists()) {
            User::create([
                'name' => 'Jhon Pastor',
                'email' => 'jhon@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: jhon@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }       
        
        // Insert test user if it does not exist
        if (!User::where('email', 'jose@gmail.com')->exists()) {
            User::create([
                'name' => 'Jose de los Bayardigans',
                'email' => 'jose@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: jose@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }         
        
        // Insert test user if it does not exist
        if (!User::where('email', 'boris@gmail.com')->exists()) {
            User::create([
                'name' => 'Boris el Varon',
                'email' => 'boris@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: boris@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }           

        // Insert test user if it does not exist
        if (!User::where('email', 'jefferson@gmail.com')->exists()) {
            User::create([
                'name' => 'Jefferson el Delegado',
                'email' => 'jefferson@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: jefferson@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }      

        // Insert test user if it does not exist
        if (!User::where('email', 'fabio@gmail.com')->exists()) {
            User::create([
                'name' => 'Pampis de Tiktok',
                'email' => 'fabio@gmail.com',
                'password' => Hash::make('123456'),
                'slug' => Str::random(22),
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("User created: fabio@gmail.com / 123456");
        } else {
            $this->warn("User already exists. No new user was created.");
        }          

        $this->info("Project successfully initialized.");
        return self::SUCCESS;
    }
}