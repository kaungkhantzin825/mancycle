<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_mm',
        'type',
        'parent_id',
        'slug',
        'latitude',
        'longitude',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($location) {
            if (empty($location->slug)) {
                $location->slug = Str::slug($location->name);
                
                // Ensure unique slug
                $count = static::where('slug', 'like', $location->slug . '%')->count();
                if ($count > 0) {
                    $location->slug = $location->slug . '-' . ($count + 1);
                }
            }
        });
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRegions($query)
    {
        return $query->where('type', 'region');
    }

    public function scopeCities($query)
    {
        return $query->where('type', 'city');
    }

    public function scopeTowns($query)
    {
        return $query->where('type', 'town');
    }

    public function scopeTownships($query)
    {
        return $query->where('type', 'township');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Helper Methods
    public function getFullNameAttribute()
    {
        $names = [$this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($names, $parent->name);
            $parent = $parent->parent;
        }
        
        return implode(', ', $names);
    }

    public function getFullNameMmAttribute()
    {
        $names = [$this->name_mm ?: $this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($names, $parent->name_mm ?: $parent->name);
            $parent = $parent->parent;
        }
        
        return implode('၊ ', $names);
    }

    public function hasCoordinates()
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    public function getCoordinates()
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude
        ];
    }

    // Get all descendants (recursive)
    public function descendants()
    {
        $descendants = collect();
        
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->descendants());
        }
        
        return $descendants;
    }

    // Get location hierarchy for breadcrumbs
    public function getBreadcrumbsAttribute()
    {
        $breadcrumbs = collect();
        $location = $this;
        
        while ($location) {
            $breadcrumbs->prepend([
                'id' => $location->id,
                'name' => $location->name,
                'slug' => $location->slug,
                'type' => $location->type
            ]);
            $location = $location->parent;
        }
        
        return $breadcrumbs;
    }
}
