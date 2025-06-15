<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $subjectLine;
    public $attachmentsList;
    public $sender;

    public function __construct($subjectLine, $body, $attachmentsList = [], $sender = null)
    {
        $this->subjectLine = $subjectLine;
        $this->body = $body;
        $this->attachmentsList = $attachmentsList;
        $this->sender = $sender;
    }

    public function build()
    {
        $email = $this->subject($this->subjectLine)
                      ->html($this->body); // Send raw HTML body

        if ($this->sender) {
            $email->from($this->sender);
        }

        // Attach uploaded files
        foreach ($this->attachmentsList as $path) {
            $email->attach(storage_path('app/public/' . $path));
        }

        $this->withSymfonyMessage(function ($message) {
            $cidMap = session('cid_images', []);
            foreach ($cidMap as $cid => $path) {
                if (file_exists($path)) {
                    $message->embedFromPath($path, $cid);
                }
            }
        });



        return $email;
    }
}
