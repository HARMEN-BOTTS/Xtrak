<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
                  ->html($this->body);

    if ($this->sender) {
        $email->from($this->sender);
    }

    // Attach files if any
    foreach ($this->attachmentsList as $path) {
        $email->attach(storage_path('app/public/' . $path));
    }

    // Embed extracted logo using raw Symfony message
    $logoPath = storage_path('app/public/mailer/extracted_logo.png');
    if (file_exists($logoPath)) {
        $this->withSymfonyMessage(function ($message) use ($logoPath) {
            $message->embedFromPath($logoPath, 'footerlogo');
        });
    }

    return $email;
}



    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Custom Mailable',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
