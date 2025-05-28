<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cre extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['question', 'response', 'number', 'candidate_id'];
   
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
