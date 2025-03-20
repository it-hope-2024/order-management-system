<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(ProductSeeder::class);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
                // Create Admin User
                User::create([
                    'name' => 'Root Admin',
                    'email' => 'root@example.com',
                    'password' => Hash::make('p@ssword123'), 
                    'is_admin' => true, 
                ]);
        
                // Create 3 Regular Users
                User::factory()->createMany([
                    [
                        'name' => 'User One',
                        'email' => 'user1@example.com',
                        'password' => Hash::make('p@ssword123'), 
                        'is_admin' => false,
                    ],
                    [
                        'name' => 'User Two',
                        'email' => 'user2@example.com',
                        'password' => Hash::make('p@ssword123'), 
                        'is_admin' => false,
                    ],
                    [
                        'name' => 'User Three',
                        'email' => 'user3@example.com',
                        'password' => Hash::make('p@ssword123'), 
                        'is_admin' => false,
                    ],
                ]);
    }
}
