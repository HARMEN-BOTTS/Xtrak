<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory,HasUuids;
    protected $fillable = ['name'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
    public function specialities()
    {
        return $this->hasMany(Speciality::class);
    }

}
