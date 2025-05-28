<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrgMcpLink extends Model
{
    use HasFactory;

    protected $table = 'trg_mcp_links';
    protected $fillable = ['trg_id', 'mcp_id'];

    public function opportunity()
    {
        return $this->belongsTo(Trgdashboard::class, 'trg_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Mcpdashboard::class, 'mcp_id');
    }
}


