<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'description', 'speciality_id'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class);
    }
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
}
