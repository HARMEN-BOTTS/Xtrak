<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtcEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ctc_id',
        'event_date',
        'type',
        'io',
        'object',
        'status',
        'feed',
        'temper',
        'comment',
        'next',
        'ech',
        'priority',
        'last_comment',
        'date_last_comment',
        'other_comment',
        'note1',
    ];


    protected $dates = ['event_date', 'date_last_comment'];

    public function ctcDashboard()
    {
        return $this->belongsTo(Ctcdashboard::class, 'ctc_id');
    }
}
