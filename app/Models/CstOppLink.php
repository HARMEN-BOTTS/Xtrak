<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CstOppLink extends Model
{
    use HasFactory;

    protected $table = 'cst_opp_links';
    protected $fillable = ['cst_id', 'opp_id'];

    public function opportunity()
    {
        return $this->belongsTo(Cstdashboard::class, 'cst_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Oppdashboard::class, 'opp_id');
    }
}




