<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OppCstLink extends Model
{
    use HasFactory;

    protected $table = 'opp_cst_links';
    protected $fillable = ['opp_id', 'cst_id'];

    public function opportunity()
    {
        return $this->belongsTo(Oppdashboard::class, 'opp_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Cstdashboard::class, 'cst_id');
    }
}
