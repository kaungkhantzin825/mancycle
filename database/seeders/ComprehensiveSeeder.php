<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Favorite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Favorite::truncate();
        Message::truncate();
        Chat::truncate();
        Listing::truncate();
        Category::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "Creating users...\n";
        $users = $this->createUsers();
        
        echo "Creating categories...\n";
        $categories = $this->createCategories();
        
        echo "Creating 200 listings...\n";
        $this->createListings($users, $categories);
        
        echo "Creating chats and messages...\n";
        $this->createChatsAndMessages($users);
        
        echo "Creating favorites...\n";
        $this->createFavorites($users);
        
        echo "\n=================================\n";
        echo "Seeding completed successfully!\n";
        echo "=================================\n";
        echo "Admin Login: admin@mancycle.com / password\n";
        echo "Dealer Login: dealer1@mancycle.com / password\n";
        echo "User Login: user1@mancycle.com / password\n";
        echo "=================================\n";
    }

    private function createUsers()
    {
        $users = [];

        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@mancycle.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'status' => 'approved',
            'phone' => '+1234567890',
            'email_verified_at' => now(),
        ]);

        // Create 5 sellers (dealers)
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'name' => "Premier Auto Dealer $i",
                'email' => "dealer$i@mancycle.com",
                'password' => Hash::make('password'),
                'role' => 'seller',
                'seller_type' => 'brand',
                'status' => 'approved',
                'phone' => "+1 555-010$i-0000",
                'company_name' => "Premium Motors Inc $i",
                'address' => "$i Dealer Boulevard, New York, NY 10001",
                'email_verified_at' => now(),
                'is_verified' => true,
            ]);
        }
        
        // Create 15 regular buyers
        $userNames = [
            'John Smith', 'Emma Johnson', 'Michael Brown', 'Sarah Davis', 'James Wilson',
            'Lisa Anderson', 'Robert Taylor', 'Jennifer Martinez', 'David Garcia', 'Maria Rodriguez',
            'William Jones', 'Elizabeth Miller', 'Richard Thomas', 'Patricia Jackson', 'Christopher White'
        ];

        for ($i = 1; $i <= 15; $i++) {
            $users[] = User::create([
                'name' => $userNames[$i - 1],
                'email' => "user$i@mancycle.com",
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'status' => 'approved',
                'phone' => "+1 555-020$i-0000",
                'address' => "$i Oak Street, Los Angeles, CA 90001",
                'email_verified_at' => now(),
            ]);
        }

        return $users;
    }

    private function createCategories()
    {
        $categories = [];

        // Car Categories
        $cars = Category::create([
            'name' => 'Cars',
            'slug' => 'cars',
            'description' => 'All types of cars and automobiles',
            'type' => 'cars',
            'icon' => 'fas fa-car',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $carSubcategories = [
            'Sedan' => ['slug' => 'sedan', 'desc' => 'Comfortable family sedans'],
            'SUV' => ['slug' => 'suv', 'desc' => 'Sport Utility Vehicles'],
            'Hatchback' => ['slug' => 'hatchback', 'desc' => 'Compact hatchback cars'],
            'Coupe' => ['slug' => 'coupe', 'desc' => 'Stylish two-door coupes'],
            'Convertible' => ['slug' => 'convertible', 'desc' => 'Open-top convertibles'],
            'Minivan' => ['slug' => 'minivan', 'desc' => 'Family minivans'],
            'Pickup Truck' => ['slug' => 'pickup-truck', 'desc' => 'Powerful pickup trucks'],
            'Sports Car' => ['slug' => 'sports-car', 'desc' => 'High-performance sports cars'],
            'Electric Car' => ['slug' => 'electric-car', 'desc' => 'Eco-friendly electric vehicles'],
            'Hybrid Car' => ['slug' => 'hybrid-car', 'desc' => 'Fuel-efficient hybrid vehicles'],
        ];

        $sortOrder = 2;
        foreach ($carSubcategories as $name => $data) {
            $categories[] = Category::create([
                'name' => $name,
                'slug' => $data['slug'],
                'description' => $data['desc'],
                'type' => 'cars',
                'parent_id' => $cars->id,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
        }

        // Motorcycle Categories
        $motorcycles = Category::create([
            'name' => 'Motorcycles',
            'slug' => 'motorcycles',
            'description' => 'All types of motorcycles and bikes',
            'type' => 'motorcycles',
            'icon' => 'fas fa-motorcycle',
            'is_active' => true,
            'sort_order' => 12,
        ]);

        $motorcycleSubcategories = [
            'Sport Bike' => ['slug' => 'sport-bike', 'desc' => 'High-speed sport motorcycles'],
            'Cruiser' => ['slug' => 'cruiser', 'desc' => 'Comfortable cruiser bikes'],
            'Touring' => ['slug' => 'touring', 'desc' => 'Long-distance touring motorcycles'],
            'Standard' => ['slug' => 'standard', 'desc' => 'Standard everyday motorcycles'],
            'Dirt Bike' => ['slug' => 'dirt-bike', 'desc' => 'Off-road dirt bikes'],
            'Scooter' => ['slug' => 'scooter', 'desc' => 'City scooters and mopeds'],
            'Electric Bike' => ['slug' => 'electric-bike', 'desc' => 'Electric motorcycles'],
        ];

        foreach ($motorcycleSubcategories as $name => $data) {
            $categories[] = Category::create([
                'name' => $name,
                'slug' => $data['slug'],
                'description' => $data['desc'],
                'type' => 'motorcycles',
                'parent_id' => $motorcycles->id,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
        }

        // Second Hand Categories
        $secondHand = Category::create([
            'name' => 'Parts & Accessories',
            'slug' => 'parts-accessories',
            'description' => 'Auto parts and accessories',
            'type' => 'second_hand',
            'icon' => 'fas fa-tools',
            'is_active' => true,
            'sort_order' => 20,
        ]);

        $partsSubcategories = [
            'Engine Parts' => ['slug' => 'engine-parts', 'desc' => 'Engine components and parts'],
            'Body Parts' => ['slug' => 'body-parts', 'desc' => 'Exterior body parts'],
            'Interior Parts' => ['slug' => 'interior-parts', 'desc' => 'Interior components'],
            'Wheels & Tires' => ['slug' => 'wheels-tires', 'desc' => 'Wheels, tires, and rims'],
            'Electronics' => ['slug' => 'electronics', 'desc' => 'Electronic components'],
            'Tools & Equipment' => ['slug' => 'tools-equipment', 'desc' => 'Automotive tools'],
        ];

        foreach ($partsSubcategories as $name => $data) {
            $categories[] = Category::create([
                'name' => $name,
                'slug' => $data['slug'],
                'description' => $data['desc'],
                'type' => 'second_hand',
                'parent_id' => $secondHand->id,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
        }

        return $categories;
    }

    private function createListings($users, $categories)
    {
        $carBrands = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma', 'Prius', '4Runner'],
            'Honda' => ['Accord', 'Civic', 'CR-V', 'Pilot', 'Odyssey', 'HR-V'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape', 'Edge', 'Ranger'],
            'Chevrolet' => ['Silverado', 'Malibu', 'Equinox', 'Tahoe', 'Camaro', 'Corvette'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'M3', 'M5'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE'],
            'Audi' => ['A4', 'A6', 'Q5', 'Q7', 'RS3'],
            'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y'],
            'Nissan' => ['Altima', 'Maxima', 'Rogue', 'Pathfinder', 'Frontier'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Palisade'],
        ];

        $motorcycleBrands = [
            'Harley-Davidson' => ['Street Glide', 'Road King', 'Fat Boy', 'Iron 883'],
            'Yamaha' => ['YZF-R1', 'MT-07', 'FZ-09', 'V-Star'],
            'Honda' => ['CBR600RR', 'Gold Wing', 'Africa Twin', 'Rebel'],
            'Kawasaki' => ['Ninja 650', 'Z900', 'Vulcan', 'Versys'],
            'Ducati' => ['Panigale V4', 'Monster', 'Multistrada', 'Scrambler'],
        ];

        $colors = ['Black', 'White', 'Silver', 'Gray', 'Red', 'Blue', 'Green', 'Pearl White', 'Metallic Blue'];
        
        $locations = [
            'New York, NY', 'Los Angeles, CA', 'Chicago, IL', 'Houston, TX', 'Phoenix, AZ',
            'Philadelphia, PA', 'San Antonio, TX', 'San Diego, CA', 'Dallas, TX', 'San Jose, CA',
            'Austin, TX', 'Jacksonville, FL', 'San Francisco, CA', 'Seattle, WA', 'Denver, CO',
            'Boston, MA', 'Nashville, TN', 'Las Vegas, NV', 'Portland, OR', 'Miami, FL',
        ];

        // Sample image URLs from Unsplash
        $carImages = [
            'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1542362567-b07e54358753?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1523983302122-73e869e1f850?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=800&h=600&fit=crop',
        ];

        $motorcycleImages = [
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1547549082-6bc09f2049ae?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1599819811279-d5ad9cccf838?w=800&h=600&fit=crop',
        ];

        $partsImages = [
            'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&h=600&fit=crop',
            'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=800&h=600&fit=crop',
        ];

        for ($i = 1; $i <= 200; $i++) {
            $user = $users[array_rand($users)];
            $category = $categories[array_rand($categories)];
            
            $isCar = str_contains($category->type, 'car');
            $isMotorcycle = str_contains($category->type, 'motorcycle');
            $isPart = str_contains($category->type, 'second_hand');
            
            if ($isCar) {
                $brandName = array_rand($carBrands);
                $brand = $brandName;
                $model = $carBrands[$brandName][array_rand($carBrands[$brandName])];
                $images = $carImages;
            } elseif ($isMotorcycle) {
                $brandName = array_rand($motorcycleBrands);
                $brand = $brandName;
                $model = $motorcycleBrands[$brandName][array_rand($motorcycleBrands[$brandName])];
                $images = $motorcycleImages;
            } else {
                $brand = null;
                $model = null;
                $images = $partsImages;
            }

            $year = rand(2015, 2024);
            $condition = ['new', 'excellent', 'good', 'fair'][array_rand(['new', 'excellent', 'good', 'fair'])];
            $mileage = $condition === 'new' ? rand(0, 100) : rand(5000, 100000);
            
            $price = $this->calculatePrice($isCar, $isMotorcycle, $condition);
            
            $title = $brand ? "$year $brand $model" : "Premium Auto Part - Item #$i";
            
            $listing = Listing::create([
                'title' => $title,
                'description' => $this->generateDescription($brand, $model, $year, $condition, $mileage),
                'price' => $price,
                'condition' => $condition,
                'category_id' => $category->id,
                'user_id' => $user->id,
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'fuel_type' => ($isCar || $isMotorcycle) ? ['gasoline', 'diesel', 'electric', 'hybrid'][array_rand(['gasoline', 'diesel', 'electric', 'hybrid'])] : null,
                'mileage' => ($isCar || $isMotorcycle) ? $mileage : null,
                'transmission' => $isCar ? ['automatic', 'manual', 'cvt'][array_rand(['automatic', 'manual', 'cvt'])] : null,
                'color' => $colors[array_rand($colors)],
                'location' => $locations[array_rand($locations)],
                'contact_phone' => $user->phone,
                'phone_privacy' => rand(0, 1),
                'status' => ['approved', 'approved', 'approved', 'pending'][array_rand(['approved', 'approved', 'approved', 'pending'])],
                'views' => rand(0, 2500),
                'is_featured' => rand(1, 10) > 8,
                'images' => json_encode(array_slice($images, 0, rand(2, 4))),
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }

    private function calculatePrice($isCar, $isMotorcycle, $condition)
    {
        if ($isCar) {
            $base = rand(20000, 75000);
        } elseif ($isMotorcycle) {
            $base = rand(5000, 20000);
        } else {
            $base = rand(100, 1500);
        }

        $multiplier = [
            'new' => 1.0,
            'excellent' => 0.85,
            'good' => 0.7,
            'fair' => 0.55
        ];

        return round($base * $multiplier[$condition], -2);
    }

    private function generateDescription($brand, $model, $year, $condition, $mileage)
    {
        if ($brand) {
            $descriptions = [
                "This $year $brand $model is in $condition condition with " . number_format($mileage) . " miles. Well-maintained vehicle with complete service history. All features are in perfect working order. Clean title, no accidents reported. Must see to appreciate!",
                "Beautiful $year $brand $model for sale! Only " . number_format($mileage) . " miles on the odometer. This vehicle has been garage-kept and shows pride of ownership. Features include leather interior, navigation, and premium sound system.",
                "Excellent $year $brand $model available. One owner, non-smoker, always serviced on time. With " . number_format($mileage) . " miles, this vehicle has plenty of life left. Recent maintenance includes new tires and brakes.",
            ];
        } else {
            $descriptions = [
                "High-quality automotive part in excellent condition. Removed from a well-maintained vehicle. Fully tested and guaranteed to work. Compatible with multiple vehicle models.",
                "Original equipment manufacturer (OEM) part available. Perfect replacement or upgrade for your vehicle. Professional installation available upon request.",
                "Premium auto part ready for installation. Save money compared to buying new. Fast shipping available nationwide.",
            ];
        }

        return $descriptions[array_rand($descriptions)];
    }

    private function createChatsAndMessages($users)
    {
        $listings = Listing::where('status', 'approved')->inRandomOrder()->take(40)->get();
        
        foreach ($listings as $listing) {
            $buyer = $users[array_rand($users)];
            
            if ($buyer->id === $listing->user_id) {
                continue;
            }

            $chat = Chat::create([
                'listing_id' => $listing->id,
                'buyer_id' => $buyer->id,
                'seller_id' => $listing->user_id,
                'created_at' => now()->subDays(rand(1, 20)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);

            $messages = [
                ['sender' => 'buyer', 'text' => 'Hi, is this still available?'],
                ['sender' => 'seller', 'text' => 'Yes, it\'s still available!'],
                ['sender' => 'buyer', 'text' => 'Great! Can I come see it this weekend?'],
                ['sender' => 'seller', 'text' => 'Sure, Saturday afternoon works for me.'],
                ['sender' => 'buyer', 'text' => 'Perfect! See you then.'],
            ];

            $messageCount = rand(2, 5);
            for ($i = 0; $i < $messageCount; $i++) {
                Message::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $messages[$i]['sender'] === 'buyer' ? $buyer->id : $listing->user_id,
                    'message' => $messages[$i]['text'],
                    'is_read' => rand(0, 1),
                    'created_at' => now()->subDays(rand(0, 5)),
                ]);
            }
        }
    }

    private function createFavorites($users)
    {
        $listings = Listing::where('status', 'approved')->get();
        
        foreach ($users as $user) {
            $favoriteCount = rand(3, 8);
            $randomListings = $listings->random(min($favoriteCount, $listings->count()));
            
            foreach ($randomListings as $listing) {
                if ($listing->user_id !== $user->id) {
                    Favorite::create([
                        'user_id' => $user->id,
                        'listing_id' => $listing->id,
                        'created_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }
    }
}
