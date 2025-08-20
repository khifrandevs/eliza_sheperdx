<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Relationship with sender (Pendeta)
    public function sender()
    {
        return $this->belongsTo(Pendeta::class, 'sender_id');
    }

    // Relationship with receiver (Pendeta)
    public function receiver()
    {
        return $this->belongsTo(Pendeta::class, 'receiver_id');
    }
}
