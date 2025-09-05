<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'buyer_id',
        'seller_id',
        'status',
        'last_message_at',
        'is_read_by_buyer',
        'is_read_by_seller',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'is_read_by_buyer' => 'boolean',
        'is_read_by_seller' => 'boolean',
    ];

    // Relationships
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('buyer_id', $userId)->orWhere('seller_id', $userId);
    }

    // Helper Methods
    public function markAsReadBy($userId)
    {
        if ($this->buyer_id == $userId) {
            $this->update(['is_read_by_buyer' => true]);
        } elseif ($this->seller_id == $userId) {
            $this->update(['is_read_by_seller' => true]);
        }
    }

    public function isUnreadBy($userId)
    {
        if ($this->buyer_id == $userId) {
            return !$this->is_read_by_buyer;
        } elseif ($this->seller_id == $userId) {
            return !$this->is_read_by_seller;
        }
        return false;
    }

    public function getOtherUser($userId)
    {
        return $this->buyer_id == $userId ? $this->seller : $this->buyer;
    }
}
