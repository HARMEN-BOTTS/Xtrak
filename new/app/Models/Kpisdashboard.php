<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kpisdashboard extends Model
{
    protected $table = 'kpis';

    protected $fillable = [
        'trg_calls_done',
        'trg_calls_obj',
        'trg_wn_done',
        'trg_nrp_done',
        'trg_ctc_done',
        'trg_ctc_obj',
        'trg_rv_done',
        'trg_rv_obj',
        'trg_bqf_done',
        'trg_bqf_obj',
        'trg_klf_done',
        'trg_klf_obj',
        'trg_hrd_done',
        'trg_hrd_obj',
        'cdt_calls_done',
        'cdt_calls_obj',
        'cdt_ctc_done',
        'cdt_refs_done',
        'cdt_cv_done',
        'cdt_cv_obj',
        'cdt_push_done',
        'cdt_push_obj',
        'cdt_cre_done',
        'cdt_cre_obj',
        'cdt_ctc_obj',
        'cdt_refs_obj',
        'trg_date',
        'ctc_date'
    ];
}




