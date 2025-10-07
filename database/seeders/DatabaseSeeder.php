<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdSlot;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Create sample ad slots
        AdSlot::create([
            'name' => 'Banner Ad 1',
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
            'minimum_bid_price' => 10.00,
            'status' => 'open',
        ]);

        AdSlot::create([
            'name' => 'Banner Ad 2',
            'start_time' => now()->addDay(),
            'end_time' => now()->addDays(2),
            'minimum_bid_price' => 15.00,
            'status' => 'upcoming',
        ]);
    }
}