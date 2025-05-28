<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['speciality_id','field_id','candidate_state_id', 'ns_date_id', 'next_step_id', 'code_cdt', 'state', 'origine', 'commentaire', 'description','suivi' ,'civ_id', 'first_name', 'last_name', 'email', 'phone', 'compagny_id', 'postal_code', 'candidate_statut_id', 'created_by', 'position_id', 'phone_2', 'certificate', 'city', 'address', 'region', 'country', 'disponibility_id', 'url_ctc', 'cre_ref', 'cre_created_at'];
    public function auteur()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function nextStep()
    {
        return $this->belongsTo(NextStep::class);
    }
    public function nsDate()
    {
        return $this->belongsTo(NsDate::class);
    }
    public function disponibility()
    {
        return $this->belongsTo(Disponibility::class);
    }
    public function civ()
    {
        return $this->belongsTo(Civ::class);
    }
    public function compagny()
    {
        return $this->belongsTo(Compagny::class);
    }
    public function files()
    {
        return $this->hasMany(File::class, 'owner_id', 'id');
    }
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
   
    public function cres()
    {
        return $this->hasMany(Cre::class);
    }
    public function candidateStatut()
    {
        return $this->belongsTo(CandidateStatut::class);
    }
    public function candidateState()
    {
        return $this->belongsTo(CandidateState::class);
    }

    public function oppLinks()
    {
        return $this->hasMany(OppCdtLink::class, 'cdt_id');
    }

    public function opportunities()
    {
        return $this->belongsToMany(Oppdashboard::class, 'opp_cdt_links', 'cdt_id', 'opp_id')
            ->withTimestamps();
    }

    public function cdt_oppLinks()
    {
        return $this->hasMany(CdtOppLink::class, 'cdt_id');
    }

    public function cdt_opportunities()
    {
        return $this->belongsToMany(Oppdashboard::class, 'cdt_opp_links', 'cdt_id', 'opp_id')
            ->withTimestamps();
    }

    public function cdt_mcpLinks()
    {
        return $this->hasMany(CdtMcpLink::class, 'cdt_id');
    }

    public function cdt_mcpopportunities()
    {
        return $this->belongsToMany(Mcpdashboard::class, 'cdt_mcp_links', 'cdt_id', 'mcp_id')
            ->withTimestamps();
    }


}
