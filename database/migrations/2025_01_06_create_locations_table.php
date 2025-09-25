<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_mm')->nullable(); // Myanmar language name
            $table->enum('type', ['region', 'city', 'town', 'township']);
            $table->foreignId('parent_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->decimal('latitude', 10, 8)->nullable(); // Optional lat/long
            $table->decimal('longitude', 11, 8)->nullable(); // Optional lat/long
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('parent_id');
            $table->index('type');
            $table->index('slug');
        });
        
        // Add location_id to listings table
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('category_id')->constrained('locations');
            $table->string('detailed_address')->nullable()->after('location');
            $table->index('location_id');
        });
        
        // Add location_id to users table for sellers
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('company_name')->constrained('locations');
            $table->string('detailed_address')->nullable()->after('address');
            $table->index('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('detailed_address');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('detailed_address');
        });
        
        Schema::dropIfExists('locations');
    }
};
