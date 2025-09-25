<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Location;

// Get all parent locations
$parents = Location::whereNull('parent_id')->get();
echo "Parent Locations:\n";
foreach ($parents as $parent) {
    echo "ID: {$parent->id}, Name: {$parent->name}, Type: {$parent->type}\n";
    
    // Get children
    $children = Location::where('parent_id', $parent->id)->get();
    if ($children->count() > 0) {
        echo "  Children:\n";
        foreach ($children as $child) {
            echo "    ID: {$child->id}, Name: {$child->name}, Type: {$child->type}\n";
            
            // Get grandchildren
            $grandchildren = Location::where('parent_id', $child->id)->get();
            if ($grandchildren->count() > 0) {
                echo "      Grandchildren:\n";
                foreach ($grandchildren as $gc) {
                    echo "        ID: {$gc->id}, Name: {$gc->name}, Type: {$gc->type}\n";
                }
            }
        }
    }
}
