<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OppCdtLink extends Model
{
    use HasFactory;
    
    protected $table = 'opp_cdt_links';
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


