<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speciality extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['name', 'description','position_id'];
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
