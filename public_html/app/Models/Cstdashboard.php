<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cstdashboard extends Model
{
    protected $table = 'cst_vue';

    protected $fillable = [
        'date_cst',
        'cst_code',
        'civ',
        'first_name',
        'last_name',
        'cell',
        'mail',
        'status',
        'notes',
    ];

    public function oppLinks()
    {
        return $this->hasMany(OppCstLink::class, 'cst_id');
    }

    public function opportunities()
    {
        return $this->belongsToMany(Oppdashboard::class, 'opp_cst_links', 'cst_id', 'opp_id')
            ->withTimestamps();
    }
}


