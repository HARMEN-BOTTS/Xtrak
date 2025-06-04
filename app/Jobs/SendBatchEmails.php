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
        // $this->batchMin = $batchMin;
        // $this->batchMax = $batchMax;
        // $this->pauseMin = $pauseMin;
        // $this->pauseMax = $pauseMax;

        $this->batchMin = !empty($batchMin) && is_numeric($batchMin) ? (int)$batchMin : 1;
        $this->batchMax = !empty($batchMax) && is_numeric($batchMax) ? (int)$batchMax : 10;
        $this->pauseMin = !empty($pauseMin) && is_numeric($pauseMin) ? (int)$pauseMin : 1;
        $this->pauseMax = !empty($pauseMax) && is_numeric($pauseMax) ? (int)$pauseMax : 5;


        if ($this->batchMin > $this->batchMax) {
            $this->batchMin = $this->batchMax;
        }

        if ($this->pauseMin > $this->pauseMax) {
            $this->pauseMin = $this->pauseMax;
        }
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
                // $paragraphs = preg_split('/\R\R+/', trim($personalized));
                // $formattedHtml = '';
                // foreach ($paragraphs as $para) {
                //     // $formattedHtml .= '<p>' . nl2br(e(trim($para))) . '</p>';
                //     $formattedHtml .= '<p>' . nl2br(trim($para)) . '</p>';
                // }

                // 2. Process HTML content properly
                $formattedHtml = $this->processWordDocContent($personalized);

                // 3. Add embedded logo and footer signature (via cid)
                // $formattedHtml .= '<br><img src="cid:footerlogo" alt="Logo" style="height:40px; margin-top:10px;">';

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


    private function processWordDocContent($content)
    {
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

        $content = str_replace([
            '&#039;',
            '&quot;',
            '&amp;',
            '&lt;',
            '&gt;',
            '\\"',
            "\\'",
            '\\n',
            '\\r',
            '\\t'
        ], [
            "'",
            '"',
            '&',
            '<',
            '>',
            '"',
            "'",
            "\n",
            "\r",
            "\t"
        ], $content);

        $content = preg_replace([
            '/[\x{2018}\x{2019}]/u',
            '/[\x{201C}\x{201D}]/u',
            '/\x{2026}/u',
            '/[\x{2013}\x{2014}]/u'
        ], [
            "'",
            '"',
            '...',
            '-'
        ], $content);

        if (preg_match('/(We Chase Talents For Industry|Barthélemy GILLES).*$/s', $content, $matches)) {
            $mainContent = substr($content, 0, strpos($content, $matches[0]));
            $signatureBlock = $matches[0];

            $mainHtml = $this->processMainContent($mainContent);

            $signatureHtml = $this->processSignatureBlock($signatureBlock);

            return $mainHtml . $signatureHtml;
        }

        return $this->processMainContent($content);
    }


    private function processMainContent($content)
    {
        $lines = explode("\n", $content);
        $formattedHtml = '<div style="margin: 0; padding: 0; line-height: 1.4;">';
        $inList = false;
        $currentParagraph = '';

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line)) {
                if ($inList) {
                    $formattedHtml .= '</ul>';
                    $inList = false;
                } elseif (!empty($currentParagraph)) {
                    $formattedHtml .= '<p style="margin: 0 0 6px 0; padding: 0; line-height: 1.4;">' . $this->formatText($currentParagraph) . '</p>';
                    $currentParagraph = '';
                }
                continue;
            }

            if (preg_match('/^[-*•·]\s+(.*)/', $line, $matches)) {
                if (!empty($currentParagraph)) {
                    $formattedHtml .= '<p style="margin: 0 0 6px 0; padding: 0; line-height: 1.4;">' . $this->formatText($currentParagraph) . '</p>';
                    $currentParagraph = '';
                }


                if (!$inList) {
                    $formattedHtml .= '<ul style="margin: 0 0 6px 0; padding-left: 20px;">';
                    $inList = true;
                }


                $listItem = $this->formatText($matches[1]);
                $formattedHtml .= '<li style="margin: 0; padding: 0;">' . $listItem . '</li>';
            } else {

                if ($inList) {
                    $formattedHtml .= '</ul>';
                    $inList = false;
                }


                if (!empty($currentParagraph)) {
                    $currentParagraph .= ' ' . $line;
                } else {
                    $currentParagraph = $line;
                }
            }
        }


        if ($inList) {
            $formattedHtml .= '</ul>';
        } elseif (!empty($currentParagraph)) {
            $formattedHtml .= '<p style="margin: 0 0 6px 0; padding: 0; line-height: 1.4;">' . $this->formatText($currentParagraph) . '</p>';
        }

        $formattedHtml .= '</div>';
        return $formattedHtml;
    }


    private function processSignatureBlock($content)
    {
        $html = '<p>';

        if (stripos($content, 'Bien à vous') !== false) {
            $html .= 'Bien à vous,<br>';
        }

        $html .= '<br>';

        $html .= '<strong style="color:#161179;">Barthélemy GILLES</strong><br>';

        if (stripos($content, 'PH Div. Manager') !== false) {
            $html .= '<span style="color:#161179;">PH Div. Manager<br>Cell : 06 88 38 63 62</span>';
        }

        $html .= '<br>';

        // ADD LOGO HERE - between contact details and company tagline
        $html .= '<img src="cid:footerlogo" alt="Harmen & Botts Logo" style="height:40px; margin:10px 0;"><br>';


        // $html .= '<br>';
        $html .= '<strong style="color:#161179;"><em>We Chase Talents For Industry</em></strong><br>';

        if (stripos($content, 'Avenue du Roule') !== false) {
            $html .= '<span style="color:#161179;">37, Avenue du Roule<br></span>';
        }

        if (stripos($content, 'Neuilly-sur-Seine') !== false) {
            $html .= '<span style="color:#161179;">92200 Neuilly-sur-Seine<br>Std : 01 84 20 46 49<br></span>';
        }


        $html .= '<a style="color:#161179;" href="http://www.harmen-botts.com">www.harmen-botts.com</a>';

        $html .= '</p>';

        return $html;
    }


    private function formatText($text)
    {
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__(.*?)__/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.*?)_/', '<em>$1</em>', $text);

        $text = preg_replace('/\[(.*?)\]\{\.underline\}/', '<u>$1</u>', $text);

        // Updated patterns with dash prefix
        $boldPatterns = [
            'Nous couvrons la totalité des métiers' => '- <strong>Nous couvrons la totalité des métiers</strong>',
            'Nous sommes rapides et agiles' => '- <strong>Nous sommes rapides et agiles</strong>',
            'Nous sommes rigoureux et déterminés' => '- <strong>Nous sommes rigoureux et déterminés</strong>',
            'Nous développons nos propres solutions' => '- <strong>Nous développons nos propres solutions</strong>',
            'Barthélemy GILLES' => '<strong>Barthélemy GILLES</strong>'
        ];

        foreach ($boldPatterns as $pattern => $replacement) {
            $text = str_replace($pattern, $replacement, $text);
        }

        $text = str_replace('Ce qui nous caractérise', '<u>Ce qui nous caractérise</u>', $text);

        return $text;
    }
}



