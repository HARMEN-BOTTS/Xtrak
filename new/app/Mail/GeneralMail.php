<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;
    public $insertion;
    public $password;
    public $file;
    // public $contact;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
       
        // $this->contact = Contact::first();
        $this->insertion = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.general.mail')->subject('Compte crée sur la plateforme XTRAK');
    }
}
