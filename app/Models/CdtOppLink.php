<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdtOppLink extends Model
{
    use HasFactory;
    
    protected $table = 'cdt_opp_links';
    protected $fillable = ['opp_id', 'cdt_id'];
    
    public function opportunity()
    {
        return $this->belongsTo(Oppdashboard::class, 'opp_id');
    }
    
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'cdt_id');
    }
}


