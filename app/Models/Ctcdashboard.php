<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ctcdashboard extends Model
{
    protected $table = 'ctc_vue';

    protected $fillable = [
        'date_ctc',
        'company_ctc',
        'civ',
        'first_name',
        'last_name',
        'function_ctc',
        'std_ctc',
        'ext_ctc',
        'ld',
        'cell',
        'mail',
        'ctc_code',
        'trg_code',
        'remarks',
        'notes',
    ];
}
