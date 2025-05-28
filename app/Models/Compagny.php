<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compagny extends Model
{
    use HasFactory,HasUuids;
    protected $fillable = ['name'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
