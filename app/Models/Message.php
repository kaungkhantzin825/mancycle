<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'attachments',
        'type',
        'is_read',
        'read_at',
        'is_translated',
        'translations',
        'is_flagged',
        'flag_reason',
    ];

    protected $casts = [
        'attachments' => 'array',
        'translations' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_translated' => 'boolean',
        'is_flagged' => 'boolean',
    ];

    // Relationships
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeFlagged($query)
    {
        return $query->where('is_flagged', true);
    }

    // Helper Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function flag($reason = null)
    {
        $this->update([
            'is_flagged' => true,
            'flag_reason' => $reason,
        ]);
    }

    public function hasAttachments()
    {
        return !empty($this->attachments);
    }
}
