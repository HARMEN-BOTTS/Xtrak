<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McpTrgLink extends Model
{
    use HasFactory;

    protected $table = 'mcp_trg_links';
    protected $fillable = ['mcp_id', 'trg_id'];

    public function opportunity()
    {
        return $this->belongsTo(Mcpdashboard::class, 'mcp_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Trgdashboard::class, 'trg_id');
    }
}


