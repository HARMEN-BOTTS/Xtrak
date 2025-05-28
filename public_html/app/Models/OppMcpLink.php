<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OppMcpLink extends Model
{
    use HasFactory;

    protected $table = 'opp_mcp_links';
    protected $fillable = ['opp_id', 'mcp_id'];

    public function opportunity()
    {
        return $this->belongsTo(Oppdashboard::class, 'opp_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Mcpdashboard::class, 'mcp_id');
    }
}


