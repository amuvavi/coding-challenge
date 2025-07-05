<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder creates a specific user that can be used for testing the system.
     */
    public function run(): void
    {
        if (! User::where('email', 'tester@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'tester@example.com',
                'password' => Hash::make('password'), 
            ]);
        }
    }
}
