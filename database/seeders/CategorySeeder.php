<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Motorcycles (Primary focus)
            [
                'name' => 'Motorcycles',
                'slug' => 'motorcycles',
                'description' => 'New and used motorcycles, sport bikes, cruisers',
                'icon' => 'fas fa-motorcycle',
                'type' => 'motorcycles',
                'is_active' => true,
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Sport Bikes', 'slug' => 'sport-bikes', 'type' => 'motorcycles'],
                    ['name' => 'Cruisers', 'slug' => 'cruisers', 'type' => 'motorcycles'],
                    ['name' => 'Touring', 'slug' => 'touring', 'type' => 'motorcycles'],
                    ['name' => 'Naked/Standard', 'slug' => 'naked-standard', 'type' => 'motorcycles'],
                    ['name' => 'Adventure', 'slug' => 'adventure', 'type' => 'motorcycles'],
                    ['name' => 'Dirt Bikes', 'slug' => 'dirt-bikes', 'type' => 'motorcycles'],
                ]
            ],
            // Scooters & Mopeds
            [
                'name' => 'Scooters & Mopeds',
                'slug' => 'scooters-mopeds',
                'description' => 'Scooters, mopeds, and small displacement bikes',
                'icon' => 'fas fa-motorcycle',
                'type' => 'scooters',
                'is_active' => true,
                'sort_order' => 2,
                'children' => [
                    ['name' => '50cc Scooters', 'slug' => '50cc-scooters', 'type' => 'scooters'],
                    ['name' => '125cc Scooters', 'slug' => '125cc-scooters', 'type' => 'scooters'],
                    ['name' => '150cc+ Scooters', 'slug' => '150cc-scooters', 'type' => 'scooters'],
                    ['name' => 'Electric Scooters', 'slug' => 'electric-scooters', 'type' => 'scooters'],
                ]
            ],
            // Cars
            [
                'name' => 'Cars',
                'slug' => 'cars',
                'description' => 'New and used cars, sedans, SUVs, trucks',
                'icon' => 'fas fa-car',
                'type' => 'cars',
                'is_active' => true,
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Sedans', 'slug' => 'sedans', 'type' => 'cars'],
                    ['name' => 'SUVs', 'slug' => 'suvs', 'type' => 'cars'],
                    ['name' => 'Hatchbacks', 'slug' => 'hatchbacks', 'type' => 'cars'],
                    ['name' => 'Convertibles', 'slug' => 'convertibles', 'type' => 'cars'],
                    ['name' => 'Trucks', 'slug' => 'trucks', 'type' => 'cars'],
                    ['name' => 'Electric Cars', 'slug' => 'electric-cars', 'type' => 'cars'],
                ]
            ],
            // Parts & Accessories
            [
                'name' => 'Parts & Accessories',
                'slug' => 'parts-accessories',
                'description' => 'Motorcycle and car parts, accessories, gear',
                'icon' => 'fas fa-cog',
                'type' => 'parts',
                'is_active' => true,
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Motorcycle Parts', 'slug' => 'motorcycle-parts', 'type' => 'parts'],
                    ['name' => 'Car Parts', 'slug' => 'car-parts', 'type' => 'parts'],
                    ['name' => 'Helmets & Gear', 'slug' => 'helmets-gear', 'type' => 'parts'],
                    ['name' => 'Tires & Wheels', 'slug' => 'tires-wheels', 'type' => 'parts'],
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);
            
            $category = Category::create($categoryData);
            
            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['is_active'] = true;
                $childData['sort_order'] = 0;
                Category::create($childData);
            }
        }
    }
}