<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'seller_type',
        'status',
        'avatar',
        'bio',
        'address',
        'detailed_address',
        'location_id',
        'latitude',
        'longitude',
        'language',
        'company_name',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    // Relationships
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'buyer_id');
    }

    public function sellerChats()
    {
        return $this->hasMany(Chat::class, 'seller_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Alias for messages relationship
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSellers($query)
    {
        return $query->whereIn('role', ['seller', 'brand_admin']);
    }

    // Helper Methods
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSeller()
    {
        return in_array($this->role, ['seller', 'brand_admin', 'dealer']);
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
