<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oppdashboard extends Model
{
    protected $table = 'opportunity_table';

    protected $fillable = [
        'opportunity_date',
        'opp_code',
        'job_titles',
        'name',
        'postal_code_1',
        'site_city',
        'opportunity_status',
        'remarks',
        'trg_code',
        'total_paid',
        'auth',
        'ctc1_code',
        'civs',
        'ctc1_first_name',
        'ctc1_last_name',
        'position',
        'specificities',
        'domain',
        'postal_code',
        'town',
        'country',
        'experience',
        'schooling',
        'schedules',
        'mobility',
        'permission',
        'type',
        'vehicle',
        'job_offer_date',
        'skill_one',
        'skill_two',
        'skill_three',
        'other_one',
        'remarks_two',
        'job_start_date',
        'invoice_date',
        'gross_salary',
        'bonus_1',
        'bonus_2',
        'bonus_3',
        'other_two',
        'date_emb'
    ];

    public function cdtLinks()
    {
        return $this->hasMany(OppCdtLink::class, 'opp_id');
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'opp_cdt_links', 'opp_id', 'cdt_id')
            ->withTimestamps();
    }

    public function opp_cdtLinks()
    {
        return $this->hasMany(CdtOppLink::class, 'opp_id');
    }

    public function opp_candidates()
    {
        return $this->belongsToMany(Candidate::class, 'cdt_opp_links', 'opp_id', 'cdt_id')
            ->withTimestamps();
    }

 
    public function cstLinks()
    {
        return $this->hasMany(OppCstLink::class, 'opp_id');
    }

    public function candidates_cst()
    {
        return $this->belongsToMany(Cstdashboard::class, 'opp_cst_links', 'opp_id', 'cst_id')
            ->withTimestamps();
    }

    public function mcpLinks()
    {
        return $this->hasMany(OppMcpLink::class, 'opp_id');
    }

    public function candidates_mcp()
    {
        return $this->belongsToMany(Mcpdashboard::class, 'opp_mcp_links', 'opp_id', 'mcp_id')
            ->withTimestamps();
    }
}


