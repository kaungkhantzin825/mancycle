<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@mancycle.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'status' => 'approved',
            'is_verified' => true,
            'approved_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Sample Sellers
        $sellers = [
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'role' => 'seller',
                'seller_type' => 'normal',
                'status' => 'approved',
                'address' => 'New York, NY',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'bio' => 'Experienced car dealer with 10+ years in the business.',
                'is_verified' => true,
                'approved_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'phone' => '+1234567891',
                'role' => 'seller',
                'seller_type' => 'normal',
                'status' => 'approved',
                'address' => 'Los Angeles, CA',
                'latitude' => 34.0522,
                'longitude' => -118.2437,
                'bio' => 'Motorcycle enthusiast selling quality bikes.',
                'is_verified' => true,
                'approved_at' => now(),
            ],
            [
                'name' => 'AutoMax Dealership',
                'email' => 'contact@automax.com',
                'phone' => '+1234567892',
                'role' => 'brand_admin',
                'seller_type' => 'brand',
                'status' => 'approved',
                'company_name' => 'AutoMax Dealership',
                'address' => 'Chicago, IL',
                'latitude' => 41.8781,
                'longitude' => -87.6298,
                'bio' => 'Premium car dealership with certified pre-owned vehicles.',
                'is_verified' => true,
                'approved_at' => now(),
            ],
        ];

        foreach ($sellers as $seller) {
            $seller['password'] = Hash::make('password');
            $seller['email_verified_at'] = now();
            User::create($seller);
        }

        // Sample Buyers
        $buyers = [
            [
                'name' => 'Mike Chen',
                'email' => 'mike@example.com',
                'role' => 'buyer',
                'status' => 'approved',
                'address' => 'Houston, TX',
                'latitude' => 29.7604,
                'longitude' => -95.3698,
            ],
            [
                'name' => 'Emma Davis',
                'email' => 'emma@example.com',
                'role' => 'buyer',
                'status' => 'approved',
                'address' => 'Phoenix, AZ',
                'latitude' => 33.4484,
                'longitude' => -112.0740,
            ],
        ];

        foreach ($buyers as $buyer) {
            $buyer['password'] = Hash::make('password');
            $buyer['email_verified_at'] = now();
            User::create($buyer);
        }
    }
}