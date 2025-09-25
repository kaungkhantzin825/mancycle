<?php
// Simple test to check location API
require_once 'vendor/autoload.php';

use App\Models\Location;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test: Get Yangon Region
echo "=== Testing Location Data ===\n";

$yangonRegion = Location::where('name', 'like', '%Yangon%')->whereNull('parent_id')->first();
if ($yangonRegion) {
    echo "Found Yangon Region: ID = {$yangonRegion->id}, Name = {$yangonRegion->name}\n";
    
    // Get children of Yangon Region
    $cities = Location::where('parent_id', $yangonRegion->id)->get();
    echo "Cities in Yangon Region: " . $cities->count() . "\n";
    
    foreach ($cities as $city) {
        echo "  - {$city->name} (ID: {$city->id}, Type: {$city->type})\n";
    }
} else {
    echo "Yangon Region not found!\n";
}

// Test API endpoint simulation
echo "\n=== Testing API Logic ===\n";
$parentId = $yangonRegion ? $yangonRegion->id : 2; // Fallback to ID 2
$children = Location::where('parent_id', $parentId)
    ->where('is_active', true)
    ->orderBy('name')
    ->get(['id', 'name', 'type']);

echo "API would return " . $children->count() . " results for parent_id = {$parentId}\n";
foreach ($children as $child) {
    echo "  - {$child->name} (ID: {$child->id})\n";
}
