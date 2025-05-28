<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['path', 'name', 'type'];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
