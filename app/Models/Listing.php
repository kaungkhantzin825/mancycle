<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'condition',
        'user_id',
        'category_id',
        'location_id',
        'status',
        'images',
        'videos',
        'specifications',
        'brand',
        'model',
        'year',
        'fuel_type',
        'mileage',
        'transmission',
        'color',
        'location',
        'detailed_address',
        'latitude',
        'longitude',
        'contact_phone',
        'phone_privacy',
        'translations',
        'is_featured',
        'featured_until',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'specifications' => 'array',
        'translations' => 'array',
        'approved_at' => 'datetime',
        'featured_until' => 'datetime',
        'phone_privacy' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Helper Methods
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isFeatured()
    {
        return $this->is_featured && ($this->featured_until === null || $this->featured_until->isFuture());
    }

    public function getMainImageAttribute()
    {
        return $this->images ? $this->images[0] : null;
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
