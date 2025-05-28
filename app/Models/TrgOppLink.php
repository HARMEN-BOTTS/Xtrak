<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrgOppLink extends Model
{
    use HasFactory;

    protected $table = 'trg_opp_links';
    protected $fillable = ['trg_id', 'opp_id'];

    public function opportunity()
    {
        return $this->belongsTo(Trgdashboard::class, 'trg_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Oppdashboard::class, 'opp_id');
    }
}



