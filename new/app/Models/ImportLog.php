<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['accepted', 'rejected', 'user_id', 'file_path'];
    protected $casts = [
        'accepted' => 'array',
        'rejected' => 'array',
    ];
}
