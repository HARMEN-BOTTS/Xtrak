<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrgEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'trg_id',
        'event_date',
        'type',
        'io',
        'object',
        'status',
        'comment',
        'next',
        'ech',
        'priority',
        'last_comment',
        'date_last_comment',
        'other_comment',
        'note1',
        'temper',
        'retour'
    ];

    protected $dates = ['event_date', 'date_last_comment'];

    public function trgDashboard()
    {
        return $this->belongsTo(Trgdashboard::class, 'trg_id');
    }
}


