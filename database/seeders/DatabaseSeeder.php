<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        
        // Create employee user
        User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'role' => 'employee',
        ]);
        
        // Create bank officer user
        User::factory()->create([
            'name' => 'Bank Officer',
            'email' => 'bank@example.com',
            'role' => 'bank_officer',
        ]);
        
        // Create customer user
        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);
        
        // Create additional regular users if needed
        // User::factory(5)->create();
    }
}
