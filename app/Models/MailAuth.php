<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailAuth extends Model
{
    protected $table = 'mail_auth';

    protected $fillable = [
        'firstname', 'lastname', 'email', 'passcode',
    ];
}