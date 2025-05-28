<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'type',
        'read',
        'body',
        'attachment',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isImageAttachment()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = pathinfo($this->attachment, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $imageExtensions);
    }
    public function getOriginalFilename()
    {
        return Storage::url($this->attachment);
    }
}

