<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use Illuminate\Mail\Mailer as LaravelMailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use App\Mail\CustomMailable;

class SendBatchEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recipients;
    public $subject;
    public $body;
    public $attachmentPaths;
    public $sender;
    public $appPassword;
    public $batchMin;
    public $batchMax;
    public $pauseMin;
    public $pauseMax;

    public function __construct($recipients, $subject, $body, $attachmentPaths, $sender, $appPassword, $batchMin, $batchMax, $pauseMin, $pauseMax)
    {
        $this->recipients = $recipients;
        $this->subject = $subject;
        $this->body = $body;
        $this->attachmentPaths = $attachmentPaths;
        $this->sender = $sender;
        $this->appPassword = $appPassword;
        $this->batchMin = $batchMin;
        $this->batchMax = $batchMax;
        $this->pauseMin = $pauseMin;
        $this->pauseMax = $pauseMax;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $transport = new EsmtpTransport('smtp.gmail.com', 587, false); // STARTTLS
        $transport->setUsername($this->sender);
        $transport->setPassword($this->appPassword);

        $mailer = new LaravelMailer('smtp', View::getFacadeRoot(), $transport, app('events'));

        $batches = array_chunk($this->recipients, rand($this->batchMin, $this->batchMax));

        foreach ($batches as $batch) {
            foreach ($batch as $recipient) {
                // 1. Personalize body text
                $personalized = str_replace(
                    ['{civility}', '{firstName}', '{lastName}', '{domain}'],
                    [$recipient['civility'], $recipient['first_name'], $recipient['last_name'], $recipient['domain']],
                    $this->body
                );

                // 2. Convert paragraphs to <p> tags
                $paragraphs = preg_split('/\R\R+/', trim($personalized));
                $formattedHtml = '';
                foreach ($paragraphs as $para) {
                    $formattedHtml .= '<p>' . nl2br(e(trim($para))) . '</p>';
                }

                // 3. Add embedded logo and footer signature (via cid)
                $formattedHtml .= '<br><img src="cid:footerlogo" alt="Logo" style="height:40px; margin-top:10px;">';

                // 4. Send mail with HTML body
                $mailer->to($recipient['email'], $recipient['first_name'] . ' ' . $recipient['last_name'])
                    ->send(new CustomMailable(
                        $this->subject,
                        $formattedHtml,
                        $this->attachmentPaths,
                        $this->sender
                    ));
            }

            sleep(rand($this->pauseMin, $this->pauseMax));
        }
    }

}
