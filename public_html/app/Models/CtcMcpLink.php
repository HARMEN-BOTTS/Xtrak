<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtcMcpLink extends Model
{
    use HasFactory;

    protected $table = 'ctc_mcp_links';
    protected $fillable = ['ctc_id', 'mcp_id'];

    public function opportunity()
    {
        return $this->belongsTo(Ctcdashboard::class, 'ctc_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Mcpdashboard::class, 'mcp_id');
    }
}
