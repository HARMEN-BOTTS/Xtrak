<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rtdashboard extends Model
{
    protected $table = 'rt_vue';

    protected $fillable = [
        'date_rt',
        'auth',
        'task_code',
        'destination',
        'type_input',
        'subject',
        'position',
        're',
        'problems',
        'corrective_actions',
        'delay',
        'remarks',
        'priority',
        'status',
        'note_one',
        'note_two',
        'rk',
        'vol'
    ];
}





