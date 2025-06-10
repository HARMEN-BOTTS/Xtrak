<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McpEmailLog extends Model
{
    protected $fillable = [
        'mcp_code',
        'launch_date',
        'hour',
        'pause',
        'status',
        'designation',
        'target_status',
        'recipient_email',
        'recipient_name',
        'company',
        'error_message'
    ];

    public function mcpCampaign()
    {
        return $this->belongsTo(Mcpdashboard::class, 'mcp_code', 'mcp_code');
    }
}