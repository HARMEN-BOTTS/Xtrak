<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdtMcpLink extends Model
{
    use HasFactory;
    
    protected $table = 'cdt_mcp_links';
    protected $fillable = ['mcp_id', 'cdt_id'];
    
    public function opportunity()
    {
        return $this->belongsTo(Mcpdashboard::class, 'mcp_id');
    }
    
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'cdt_id');
    }
}


