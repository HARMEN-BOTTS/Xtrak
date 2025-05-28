<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrgCtcLink extends Model
{
    use HasFactory;

    protected $table = 'trg_ctc_links';
    protected $fillable = ['trg_id', 'ctc_id'];

    public function opportunity()
    {
        return $this->belongsTo(Trgdashboard::class, 'trg_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Ctcdashboard::class, 'ctc_id');
    }
}
