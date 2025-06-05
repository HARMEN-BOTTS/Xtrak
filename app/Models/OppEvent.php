<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OppEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'opp_id',
        'event_date',
        'type',
        'io',
        'object',
        'feedback',
        'status',
        'comment',
        'next1',
        'term',
        'note1'
    ];

    protected $dates = ['event_date'];

    public function oppDashboard()
    {
        return $this->belongsTo(Oppdashboard::class, 'opp_id');
    }
}
