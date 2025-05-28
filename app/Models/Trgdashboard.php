<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trgdashboard extends Model
{
    protected $table = 'trg_vue';

    protected $fillable = [
        'creation_date',
        'company',
        'standard_phone',
        'postal_code_department',
        'title',
        'first_name',
        'last_name',
        'position',
        'email',
        'mobile',
        'event_date',
        'type',
        'subject',
        'event_status',
        'comment_trg',
        'next_step',
        'auth',
        'website_url',
        'trg_code',
        'address',
        'address_one',
        'region',
        'town',
        'country',
        'ca_k',
        'employees',
        'activity',
        'type',
        'siret',
        'rcs',
        'filiation',
        'off',
        'legal_form',
        'vat_number',
        'trg_status',
        'remarks',
        'notes',
        'last_modification_date',
        'priority'
    ];
}





