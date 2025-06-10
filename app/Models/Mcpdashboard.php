<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcpdashboard extends Model
{
    protected $table = 'mcp_vue';

    protected $fillable = [
        'date_mcp',
        'mcp_code',
        'designation',
        'object',
        'tag_source',
        'message',
        'tool',
        'remarks',
        'notes',
        'recip_list_path',
        'message_doc',
        'attachments',
        'from_email',
        'subject',
        'launch_date',
        'pause_min',
        'pause_max',
        'batch_min',
        'batch_max',
        'work_time_start',
        'work_time_end',
        'ref_time',
        'status',
        'status_date',
        'target_status',
        'total_mails',
        'success_count',
        'fails_count',
    ];

    public function oppLinks()
    {
        return $this->hasMany(OppMcpLink::class, 'mcp_id');
    }

    public function opportunities()
    {
        return $this->belongsToMany(Oppdashboard::class, 'opp_mcp_links', 'mcp_id', 'opp_id')
            ->withTimestamps();
    }

    public function cdtLinks()
    {
        return $this->hasMany(CdtMcpLink::class, 'mcp_id');
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'cdt_mcp_links', 'mcp_id', 'cdt_id')
            ->withTimestamps();
    }
}


