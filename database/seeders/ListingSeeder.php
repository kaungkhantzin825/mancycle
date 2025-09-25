<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = User::where('role', '!=', 'buyer')->get();
        $superAdmin = User::where('role', 'super_admin')->first();

        // Get categories
        $motorcycleCategories = Category::where('type', 'motorcycles')->whereNotNull('parent_id')->get();
        $carCategories = Category::where('type', 'cars')->whereNotNull('parent_id')->get();
        $scooterCategories = Category::where('type', 'scooters')->whereNotNull('parent_id')->get();

        $listings = [
            // Featured Motorcycles
            [
                'title' => '2023 Yamaha YZF-R1 - Track Ready Superbike',
                'description' => 'Pristine 2023 Yamaha YZF-R1 with only 2,500 miles. This superbike features the latest crossplane crankshaft engine, advanced electronics package, and Öhlins suspension. Perfect for track days or spirited street riding. Includes all original documentation and two keys.',
                'price' => 18500,
                'condition' => 'excellent',
                'brand' => 'Yamaha',
                'model' => 'YZF-R1',
                'year' => 2023,
                'fuel_type' => 'Gasoline',
                'mileage' => 2500,
                'transmission' => 'Manual',
                'color' => 'Team Yamaha Blue',
                'location' => 'Los Angeles, CA',
                'category_type' => 'motorcycles',
                'is_featured' => true,
                'views' => 1250,
            ],
            [
                'title' => '2022 Harley-Davidson Street Glide Special',
                'description' => 'Immaculate Harley-Davidson Street Glide Special with Milwaukee-Eight 114 engine. Features include Boom! Box GTS infotainment, premium audio, LED lighting, and comfortable touring setup. Perfect for long-distance cruising with style and comfort.',
                'price' => 28900,
                'condition' => 'excellent',
                'brand' => 'Harley-Davidson',
                'model' => 'Street Glide Special',
                'year' => 2022,
                'fuel_type' => 'Gasoline',
                'mileage' => 8500,
                'transmission' => 'Manual',
                'color' => 'Vivid Black',
                'location' => 'Phoenix, AZ',
                'category_type' => 'motorcycles',
                'is_featured' => true,
                'views' => 890,
            ],
            [
                'title' => '2021 Kawasaki Ninja ZX-10R - Race Replica',
                'description' => 'Stunning Kawasaki Ninja ZX-10R in KRT edition colors. This superbike boasts 200+ horsepower, advanced traction control, and race-proven chassis. Meticulously maintained with full service history. Includes tank pad, frame sliders, and aftermarket exhaust.',
                'price' => 16800,
                'condition' => 'excellent',
                'brand' => 'Kawasaki',
                'model' => 'Ninja ZX-10R',
                'year' => 2021,
                'fuel_type' => 'Gasoline',
                'mileage' => 4200,
                'transmission' => 'Manual',
                'color' => 'KRT Edition Lime Green',
                'location' => 'Miami, FL',
                'category_type' => 'motorcycles',
                'is_featured' => true,
                'views' => 1100,
            ],
            [
                'title' => '2020 Honda CBR1000RR-R Fireblade SP',
                'description' => 'Rare Honda CBR1000RR-R Fireblade SP with premium Öhlins suspension and Brembo brakes. This track-focused superbike delivers MotoGP-derived technology in a street-legal package. Includes quick shifter, launch control, and multiple riding modes.',
                'price' => 24500,
                'condition' => 'excellent',
                'brand' => 'Honda',
                'model' => 'CBR1000RR-R Fireblade SP',
                'year' => 2020,
                'fuel_type' => 'Gasoline',
                'mileage' => 3800,
                'transmission' => 'Manual',
                'color' => 'Grand Prix Red',
                'location' => 'Austin, TX',
                'category_type' => 'motorcycles',
                'is_featured' => true,
                'views' => 950,
            ],
            [
                'title' => '2023 BMW R1250GS Adventure - World Traveler',
                'description' => 'Ultimate adventure motorcycle with BMW\'s legendary boxer engine. Features include dynamic ESA suspension, TFT display, heated grips, and aluminum panniers. Perfect for both daily commuting and transcontinental adventures.',
                'price' => 22900,
                'condition' => 'new',
                'brand' => 'BMW',
                'model' => 'R1250GS Adventure',
                'year' => 2023,
                'fuel_type' => 'Gasoline',
                'mileage' => 1200,
                'transmission' => 'Manual',
                'color' => 'Rallye Style',
                'location' => 'Denver, CO',
                'category_type' => 'motorcycles',
                'is_featured' => true,
                'views' => 780,
            ],
            // More Motorcycles
            [
                'title' => '2019 Ducati Panigale V4 S - Italian Superbike',
                'description' => 'Exotic Ducati Panigale V4 S with 214 horsepower V4 engine. Features Öhlins suspension, Brembo Stylema brakes, and full electronics package. This Italian masterpiece combines stunning looks with incredible performance.',
                'price' => 19900,
                'condition' => 'excellent',
                'brand' => 'Ducati',
                'model' => 'Panigale V4 S',
                'year' => 2019,
                'fuel_type' => 'Gasoline',
                'mileage' => 6500,
                'transmission' => 'Manual',
                'color' => 'Ducati Red',
                'location' => 'Las Vegas, NV',
                'category_type' => 'motorcycles',
                'is_featured' => false,
                'views' => 650,
            ],
            [
                'title' => '2022 Indian Scout Bobber - American Cruiser',
                'description' => 'Beautiful Indian Scout Bobber with liquid-cooled V-twin engine. Features blacked-out styling, comfortable ergonomics, and classic American cruiser appeal. Perfect for weekend rides and daily commuting.',
                'price' => 13500,
                'condition' => 'excellent',
                'brand' => 'Indian',
                'model' => 'Scout Bobber',
                'year' => 2022,
                'fuel_type' => 'Gasoline',
                'mileage' => 5200,
                'transmission' => 'Manual',
                'color' => 'Thunder Black',
                'location' => 'Nashville, TN',
                'category_type' => 'motorcycles',
                'is_featured' => false,
                'views' => 420,
            ],
            // Scooters
            [
                'title' => '2023 Vespa GTS 300 Super - Italian Style',
                'description' => 'Classic Vespa GTS 300 with modern reliability. Features include ABS, traction control, smartphone connectivity, and under-seat storage. Perfect for urban commuting with timeless Italian style.',
                'price' => 6800,
                'condition' => 'new',
                'brand' => 'Vespa',
                'model' => 'GTS 300 Super',
                'year' => 2023,
                'fuel_type' => 'Gasoline',
                'mileage' => 500,
                'transmission' => 'Automatic',
                'color' => 'Bianco Innocenza',
                'location' => 'San Francisco, CA',
                'category_type' => 'scooters',
                'is_featured' => false,
                'views' => 280,
            ],
            // Cars
            [
                'title' => '2022 BMW M3 Competition - Performance Sedan',
                'description' => 'Ultimate driving machine with twin-turbo inline-6 engine producing 503 horsepower. Features M-specific suspension, carbon fiber trim, and track-ready performance. Perfect blend of luxury and track capability.',
                'price' => 78900,
                'condition' => 'excellent',
                'brand' => 'BMW',
                'model' => 'M3 Competition',
                'year' => 2022,
                'fuel_type' => 'Gasoline',
                'mileage' => 8500,
                'transmission' => 'Automatic',
                'color' => 'Alpine White',
                'location' => 'Chicago, IL',
                'category_type' => 'cars',
                'is_featured' => false,
                'views' => 340,
            ],
            [
                'title' => '2021 Porsche 911 Carrera S - Sports Car Icon',
                'description' => 'Legendary Porsche 911 with twin-turbo flat-6 engine. Features sport suspension, premium interior, and timeless 911 design. This sports car icon delivers incredible performance and everyday usability.',
                'price' => 125000,
                'condition' => 'excellent',
                'brand' => 'Porsche',
                'model' => '911 Carrera S',
                'year' => 2021,
                'fuel_type' => 'Gasoline',
                'mileage' => 12000,
                'transmission' => 'Automatic',
                'color' => 'Guards Red',
                'location' => 'Beverly Hills, CA',
                'category_type' => 'cars',
                'is_featured' => false,
                'views' => 890,
            ],
        ];

        foreach ($listings as $listingData) {
            // Find appropriate category based on type
            $category = null;
            switch ($listingData['category_type']) {
                case 'motorcycles':
                    $category = $motorcycleCategories->where('slug', 'sport-bikes')->first() 
                        ?? $motorcycleCategories->first();
                    break;
                case 'scooters':
                    $category = $scooterCategories->first();
                    break;
                case 'cars':
                    $category = $carCategories->where('slug', 'sedans')->first() 
                        ?? $carCategories->first();
                    break;
            }

            if ($category) {
                unset($listingData['category_type']);
                $listingData['category_id'] = $category->id;
                $listingData['user_id'] = $sellers->random()->id;
                $listingData['status'] = 'approved';
                $listingData['created_at'] = now()->subDays(rand(1, 30));
                $listingData['updated_at'] = $listingData['created_at'];

                Listing::create($listingData);
            }
        }

        // Myanmar demo listings for Yangon Region -> Insein
        $insein = Location::where('name', 'Insein')->first();
        if ($insein) {
            $yangonDemoListings = [
                [
                    'title' => 'Toyota Mark II 2002 - Good Condition (Insein)',
                    'description' => 'Right hand drive, well maintained. Aircon cold, engine smooth. Registered in Yangon. Test drive available in Insein.',
                    'price' => 18500,
                    'condition' => 'good',
                    'brand' => 'Toyota',
                    'model' => 'Mark II',
                    'year' => 2002,
                    'fuel_type' => 'Gasoline',
                    'mileage' => 125000,
                    'transmission' => 'Automatic',
                    'color' => 'Silver',
                    'category_pick' => 'cars',
                ],
                [
                    'title' => 'Honda Dio 110cc 2019 - Daily Use (Insein)',
                    'description' => 'Reliable scooter for city commuting. Good fuel economy. Kept under shade. Location: Insein Township.',
                    'price' => 780,
                    'condition' => 'excellent',
                    'brand' => 'Honda',
                    'model' => 'Dio 110',
                    'year' => 2019,
                    'fuel_type' => 'Gasoline',
                    'mileage' => 9000,
                    'transmission' => 'Automatic',
                    'color' => 'White',
                    'category_pick' => 'scooters',
                ],
                [
                    'title' => 'Yamaha FZ-S 150cc 2018 - Clean Bike (Insein)',
                    'description' => 'No accident, smooth engine, new tires. Great for Yangon traffic. Viewing in Insein.',
                    'price' => 980,
                    'condition' => 'good',
                    'brand' => 'Yamaha',
                    'model' => 'FZ-S',
                    'year' => 2018,
                    'fuel_type' => 'Gasoline',
                    'mileage' => 22000,
                    'transmission' => 'Manual',
                    'color' => 'Black',
                    'category_pick' => 'motorcycles',
                ],
            ];

            foreach ($yangonDemoListings as $data) {
                // Choose category set by type bucket
                $category = null;
                switch ($data['category_pick']) {
                    case 'cars':
                        $category = $carCategories->first();
                        break;
                    case 'motorcycles':
                        $category = $motorcycleCategories->first();
                        break;
                    case 'scooters':
                        $category = $scooterCategories->first();
                        break;
                }
                if (!$category) continue;

                $payload = [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'condition' => $data['condition'],
                    'brand' => $data['brand'],
                    'model' => $data['model'],
                    'year' => $data['year'],
                    'fuel_type' => $data['fuel_type'],
                    'mileage' => $data['mileage'],
                    'transmission' => $data['transmission'],
                    'color' => $data['color'],
                    'location' => $insein->full_name,
                    'location_id' => $insein->id,
                    'category_id' => $category->id,
                    'user_id' => ($superAdmin?->id) ?? $sellers->random()->id,
                    'status' => 'approved',
                    'created_at' => now()->subDays(rand(1, 7)),
                    'updated_at' => now()->subDays(rand(1, 7)),
                ];

                Listing::create($payload);
            }
        }
    }
}