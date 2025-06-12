<?php

namespace App\Livewire\Back\Mcpform;

use Livewire\Component;
use App\Models\Mcpdashboard;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Mail\MailManager;
use App\Mail\CustomMailable;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Illuminate\Mail\Mailer as LaravelMailer;
use Carbon\Carbon;
use Symfony\Component\Mailer\Transport\TransportInterface;
use App\Jobs\SendBatchEmails;
use App\Models\MailAuth;
// use PhpOffice\PhpWord\Shared\ZipArchive;
use ZipArchive;


class Index extends Component
{
    use WithFileUploads;
    public $date_mcp, $mcp_code, $designation, $object, $tag_source, $message, $tool;
    public $recip_list_path, $message_doc, $attachments = [];
    public $from, $subject, $launch_date, $pause_min, $pause_max, $batch_min, $batch_max;
    public $work_time_start, $work_time_end, $ref_time, $status, $status_date, $target_status, $remarks, $notes;


    public $editId;
    public $isEditing = false;

    public $entries;
    public $passcode;
    public $mailOptions = [];

    // protected $rules = [
    //     'date_ctc' => 'required|date',
    //     'ctc_code' => 'required|string|max:255',
    //     'first_name' => 'required|string|max:255',
    //     'last_name' => 'required|string|max:255',
    // ];

    public function mount()
    {
        $this->loadEntries();
        $this->date_mcp = date('Y-m-d');
        $this->mailOptions = MailAuth::all();
    }

    public function loadEntries()
    {
        $this->entries = Mcpdashboard::all();
    }

    public function fetchPasscode()
    {
        $selected = \App\Models\MailAuth::where('email', $this->from)->first();
        $this->passcode = $selected?->passcode ?? '';
    }

    private function generateMcpCode()
    {
        // Extract useful information from form fields
        $designationPart = $this->designation ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->designation), 0, 2)) : 'XX';

        $objectPart = $this->object ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->object), 0, 2)) : 'YY';

        $toolPart = $this->tool ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->tool), 0, 1)) : 'Z';

        // Combine parts to create a base for our code (5 characters so far)
        $baseCode = $designationPart . $objectPart . $toolPart;

        // Generate the remaining characters with randomness to ensure uniqueness
        // Only using alphabetic characters (A-Z)
        $remainingLength = 8 - strlen($baseCode);
        $randomChars = '';
        for ($i = 0; $i < $remainingLength; $i++) {
            $randomChars .= chr(rand(65, 90)); // ASCII codes for A-Z
        }

        $code = $baseCode . $randomChars;

        // Check if this code already exists in the database
        $codeExists = Mcpdashboard::where('mcp_code', $code)->exists();

        // If code already exists, regenerate until we get a unique one
        $attempts = 0;
        while ($codeExists && $attempts < 10) {
            $randomChars = '';
            for ($i = 0; $i < $remainingLength; $i++) {
                $randomChars .= chr(rand(65, 90)); // ASCII codes for A-Z
            }

            $code = $baseCode . $randomChars;
            $codeExists = Mcpdashboard::where('mcp_code', $code)->exists();
            $attempts++;
        }

        // If we still couldn't generate a unique code after several attempts,
        // create a completely random one as a fallback
        if ($codeExists) {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= chr(rand(65, 90)); // ASCII codes for A-Z
            }

            // Make sure even the completely random code is unique
            while (Mcpdashboard::where('mcp_code', $code)->exists()) {
                $code = '';
                for ($i = 0; $i < 8; $i++) {
                    $code .= chr(rand(65, 90)); // ASCII codes for A-Z
                }
            }
        }

        return $code;
    }


    public function save()
    {
        // $this->validate();

        $this->mcp_code = $this->generateMcpCode();

        if ($this->isEditing) {
            $entry = Mcpdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'date_mcp' => $this->date_mcp,
                    'mcp_code' => $this->mcp_code,
                    'designation' => $this->designation,
                    'object' => $this->object,
                    'tag_source' => $this->tag_source,
                    'message' => $this->message,
                    'tool' => $this->tool,
                    'recip_list_path' => $recip_list_path,
                    'message_doc' => $message_doc_path,
                    'attachments' => json_encode($attachments_paths),
                    'passcode' => $this->passcode,
                    'from_email' => $this->from,
                    'subject' => $this->subject,
                    'launch_date' => $this->launch_date,
                    'pause_min' => $this->pause_min,
                    'pause_max' => $this->pause_max,
                    'batch_min' => $this->batch_min,
                    'batch_max' => $this->batch_max,
                    'work_time_start' => $this->work_time_start,
                    'work_time_end' => $this->work_time_end,
                    'ref_time' => $this->ref_time,
                    'status' => $this->status,
                    'status_date' => $this->status_date,
                    'target_status' => $this->target_status,
                    'remarks' => $this->remarks,
                    'notes' => $this->notes,
                ]);

                $this->dispatch('alert', type: 'success', message: "Record updated successfully!");
            }
        } else {
            // Create directories
            if (!Storage::disk('public')->exists('mcp/recipients')) {
                Storage::disk('public')->makeDirectory('mcp/recipients');
            }
            if (!Storage::disk('public')->exists('mcp/messages')) {
                Storage::disk('public')->makeDirectory('mcp/messages');
            }
            if (!Storage::disk('public')->exists('mcp/attachments')) {
                Storage::disk('public')->makeDirectory('mcp/attachments');
            }

            // Store files
            $recip_list_path = $this->recip_list_path ? $this->recip_list_path->store('mcp/recipients', 'public') : null;
            $message_doc_path = $this->message_doc ? $this->message_doc->store('mcp/messages', 'public') : null;

            $attachments_paths = [];
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('mcp/attachments', $originalName, 'public');
                    $attachments_paths[] = $path;
                }
            }

            // Read recipients from Excel ONCE and count TOTAL vs VALID
            $allRecipients = [];
            $validRecipients = [];
            $totalEmailsInFile = 0;

            if ($recip_list_path) {
                $spreadsheet = IOFactory::load(storage_path('app/public/' . $recip_list_path));
                $sheet = $spreadsheet->getActiveSheet();
                $startRow = 2;

                foreach ($sheet->getRowIterator($startRow) as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $email = $firstName = $lastName = $civility = $domain = '';

                    foreach ($cellIterator as $cell) {
                        $col = $cell->getColumn();
                        $val = trim($cell->getFormattedValue());

                        if ($col === 'E') $email = $val;
                        elseif ($col === 'C') $firstName = $val;
                        elseif ($col === 'D') $lastName = $val;
                        elseif ($col === 'B') $civility = $val;
                        elseif ($col === 'G') $domain = $val;
                    }

                    // Count every row with an email (even if invalid)
                    if (!empty($email)) {
                        $totalEmailsInFile++;

                        $recipientData = [
                            'email' => $email,
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'civility' => $civility,
                            'domain' => $domain,
                        ];

                        // Add to allRecipients (includes invalid emails)
                        $allRecipients[] = $recipientData;

                        // Only add valid emails to validRecipients for actual processing
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $validRecipients[] = $recipientData;
                        }
                    }
                }
            }

            // Convert message DOCX/PDF to HTML using LibreOffice
            $htmlMessage = null;
            if ($message_doc_path) {
                $docPath = storage_path('app/public/' . $message_doc_path);
                $htmlMessage = $this->convertToHtmlWithImages($docPath);
            }

            

            // Create database record with TOTAL emails from file (not just valid ones)
            Mcpdashboard::create([
                'date_mcp' => $this->date_mcp,
                'mcp_code' => $this->mcp_code,
                'designation' => $this->designation,
                'object' => $this->object,
                'tag_source' => $this->tag_source,
                'message' => $this->message,
                'tool' => $this->tool,
                'recip_list_path' => $recip_list_path,
                'message_doc' => $message_doc_path,
                'attachments' => json_encode($attachments_paths),
                'from_email' => $this->from,
                'subject' => $this->subject,
                'launch_date' => $this->launch_date,
                'pause_min' => $this->pause_min,
                'pause_max' => $this->pause_max,
                'batch_min' => $this->batch_min,
                'batch_max' => $this->batch_max,
                'work_time_start' => $this->work_time_start,
                'work_time_end' => $this->work_time_end,
                'ref_time' => $this->ref_time,
                'status' => $this->status,
                'status_date' => $this->status_date,
                'target_status' => $this->target_status,
                'remarks' => $this->remarks,
                'notes' => $this->notes,
                'total_mails' => $totalEmailsInFile, // This should be 10 (total emails in file)
                'success_count' => 0,
                'fails_count' => 0,
            ]);

            // Dispatch job with ALL recipients (including invalid ones)
            // The job will handle validation and count failures properly
            $launchTime = $this->launch_date ? Carbon::parse($this->launch_date) : now();

            dispatch(new SendBatchEmails(
                $allRecipients,
                $this->subject,
                $htmlMessage, // ✅ Use the HTML message generated by LibreOffice
                $attachments_paths,
                $this->from,
                $this->passcode,
                $this->batch_min,
                $this->batch_max,
                $this->pause_min,
                $this->pause_max,
                $this->mcp_code
            ))->delay($launchTime);

            $this->dispatch('alert', type: 'success', message: "Form submitted and email campaign scheduled");
        }

        $this->resetForm();
        $this->loadEntries();
    }

    private function convertToHtmlWithImages($inputPath)
    {
        $outputDir = storage_path('app/public/mcp/html_output');
        $filename = pathinfo($inputPath, PATHINFO_FILENAME);

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $tempImageDir = $outputDir . '/temp_images';
        if (!file_exists($tempImageDir)) {
            mkdir($tempImageDir, 0777, true);
        }

        $sofficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
        $command = $sofficePath . ' --headless --convert-to html --outdir ' . escapeshellarg($outputDir) . ' ' . escapeshellarg($inputPath);
        exec($command . ' 2>&1', $output, $returnCode);

        $possibleFiles = glob($outputDir . '/' . $filename . '*.htm*');
        $htmlPath = $possibleFiles[0] ?? null;

        if (!$htmlPath || !file_exists($htmlPath)) {
            \Log::error("LibreOffice conversion failed", [
                'command' => $command,
                'output' => $output,
                'return_code' => $returnCode,
            ]);
            throw new \Exception("HTML conversion failed:\n" . implode("\n", $output));
        }

        $htmlContent = file_get_contents($htmlPath);
        $relsMap = $this->getImageRelsMap($inputPath);
        $cidCounter = 1;
        $cidMap = [];

        $htmlContent = preg_replace_callback('/<(img|v:imagedata)[^>]+(src|r:id)=["\']([^"\']+)["\']/i', function ($matches) use ($outputDir, $tempImageDir, $relsMap, &$cidCounter, &$cidMap) {
            $attrValue = $matches[3];

            if (str_starts_with($attrValue, 'rId') && isset($relsMap[$attrValue])) {
                $attrValue = $relsMap[$attrValue];
            }

            $originalImagePath = $outputDir . '/' . $attrValue;

            if (!file_exists($originalImagePath)) {
                $subdirs = glob($outputDir . '/*', GLOB_ONLYDIR);
                foreach ($subdirs as $subdir) {
                    $try = $subdir . '/' . basename($attrValue);
                    if (file_exists($try)) {
                        $originalImagePath = $try;
                        break;
                    }
                }
            }

            if (file_exists($originalImagePath)) {
                $ext = 'png'; // Force consistent extension
                $cidName = 'signature_logo_' . $cidCounter;
                $cidCounter++;

                $image = imagecreatefromstring(file_get_contents($originalImagePath));
                if ($image === false) return $matches[0];

                $cidPath = $tempImageDir . '/' . $cidName . '.' . $ext;
                imagepng($image, $cidPath);
                imagedestroy($image);

                $cidMap[$cidName] = $cidPath;
                return str_replace($matches[3], "cid:$cidName", $matches[0]);
            }

            return $matches[0];
        }, $htmlContent);

        // Store CID map for use in mailable
        session([ 'cid_images' => $cidMap ]);

        return $htmlContent;
    }

    private function getImageRelsMap($docxPath)
    {
        $map = [];
        $zip = new \ZipArchive();
        if ($zip->open($docxPath) === true) {
            $relsXml = $zip->getFromName('word/_rels/document.xml.rels');
            if ($relsXml) {
                $xml = simplexml_load_string($relsXml);
                foreach ($xml->Relationship as $rel) {
                    $id = (string) $rel['Id'];
                    $target = (string) $rel['Target'];
                    if (str_starts_with($target, 'media/')) {
                        $map[$id] = 'word/' . $target;
                    }
                }
            }
            $zip->close();
        }
        return $map;
    }




    public $previewMessage = '';
    public $previewRecipientEmail = '';

    public function generatePreview($targetEmail = null)
    {
        $messageDocPath = $this->message_doc ? $this->message_doc->store('temp/message_preview', 'public') : null;
        $recipListPath = $this->recip_list_path ? $this->recip_list_path->store('temp/recip_preview', 'public') : null;

        if (!$messageDocPath || !$recipListPath) {
            $this->previewMessage = 'Missing message document or recipient list.';
            return;
        }

        $docPath = storage_path('app/public/' . $messageDocPath);
        $recipPath = storage_path('app/public/' . $recipListPath);

        $htmlMessage = $this->convertToHtmlWithImages($docPath);

        $spreadsheet = IOFactory::load($recipPath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator(2) as $row) {
            $data = [];
            foreach ($row->getCellIterator() as $cell) {
                $col = $cell->getColumn();
                $val = trim($cell->getFormattedValue());

                if ($col === 'E') $data['email'] = $val;
                if ($col === 'C') $data['first_name'] = $val;
                if ($col === 'D') $data['last_name'] = $val;
                if ($col === 'B') $data['civility'] = $val;
                if ($col === 'G') $data['domain'] = $val;
            }

            if (filter_var($data['email'] ?? null, FILTER_VALIDATE_EMAIL)) {
                if ($targetEmail && $data['email'] !== $targetEmail) continue;

                $personalized = str_replace(
                    ['{civility}', '{firstName}', '{lastName}', '{domain}'],
                    [$data['civility'] ?? '', $data['first_name'] ?? '', $data['last_name'] ?? '', $data['domain'] ?? ''],
                    $htmlMessage
                );

                $cidMap = session('cid_images', []);
                foreach ($cidMap as $cid => $path) {
                    if (file_exists($path)) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $base64 = base64_encode(file_get_contents($path));
                        $htmlMessage = str_replace("cid:$cid", "data:image/$ext;base64,$base64", $htmlMessage);
                    }
                }

                $this->previewMessage = $htmlMessage;
                $this->previewRecipientEmail = $data['email'];
                break;
            }
        }
    }

    // public function generatePreview($targetEmail = null)
    // {
    //     // 1. Read message content
    //     $docPath = storage_path('app/public/' . $this->message_doc->store('temp/message_preview', 'public'));
    //     $reader = WordIOFactory::createReader('Word2007');
    //     $doc = $reader->load($docPath);
    //     $messageTemplate = '';
    //     foreach ($doc->getSections() as $section) {
    //         foreach ($section->getElements() as $element) {
    //             if (method_exists($element, 'getText')) {
    //                 $text = $element->getText();
    //                 $textString = is_array($text) ? implode(" ", $text) : $text;
    //                 if (!empty(trim($textString))) {
    //                     $textString = is_array($text) ? implode(" ", $text) : $text;
    //                     $messageTemplate .= $textString . "\n\n";
    //                 }
    //             }
    //             // Also check for TextRun elements which might contain the actual paragraphs
    //             elseif (method_exists($element, 'getElements')) {
    //                 foreach ($element->getElements() as $subElement) {
    //                     if (method_exists($subElement, 'getText')) {
    //                         $text = $subElement->getText();
    //                         if (!empty(trim($text))) {
    //                             $messageTemplate .= $text . "\n\n";
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Clean up extra line breaks
    //     $messageTemplate = preg_replace('/\n{3,}/', "\n\n", trim($messageTemplate));


    //     // 2. Read recipients Excel
    //     $spreadsheet = IOFactory::load(storage_path('app/public/' . $this->recip_list_path->store('temp/recip_preview', 'public')));
    //     $sheet = $spreadsheet->getActiveSheet();

    //     foreach ($sheet->getRowIterator(2) as $row) {
    //         $data = [];
    //         foreach ($row->getCellIterator() as $cell) {
    //             $col = $cell->getColumn();
    //             $val = trim($cell->getFormattedValue());

    //             if ($col === 'E') $data['email'] = $val;
    //             if ($col === 'C') $data['first_name'] = $val;
    //             if ($col === 'D') $data['last_name'] = $val;
    //             if ($col === 'B') $data['civility'] = $val;
    //             if ($col === 'G') $data['domain'] = $val;
    //         }

    //         if (filter_var($data['email'] ?? null, FILTER_VALIDATE_EMAIL)) {
    //             // If filtering by specific email
    //             if ($targetEmail && $data['email'] !== $targetEmail) continue;

    //             // 3. Personalize the message
    //             $personalizedMessage = str_replace(
    //                 ['{civility}', '{firstName}', '{lastName}', '{domain}'],
    //                 [$data['civility'] ?? '', $data['first_name'] ?? '', $data['last_name'] ?? '', $data['domain'] ?? ''],
    //                 $messageTemplate
    //             );

    //             // 4. Process with same HTML formatting as email job
    //             $this->previewMessage = $this->processWordDocContentForPreview($personalizedMessage);
    //             $this->previewRecipientEmail = $data['email'];
    //             break;
    //         }
    //     }
    // }

    // private function processWordDocContentForPreview($content)
    // {
    //     // Same processing as in SendBatchEmails job
    //     $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

    //     $content = str_replace([
    //         '&#039;',
    //         '&quot;',
    //         '&amp;',
    //         '&lt;',
    //         '&gt;',
    //         '\\"',
    //         "\\'",
    //         '\\n',
    //         '\\r',
    //         '\\t'
    //     ], [
    //         "'",
    //         '"',
    //         '&',
    //         '<',
    //         '>',
    //         '"',
    //         "'",
    //         "\n",
    //         "\r",
    //         "\t"
    //     ], $content);

    //     $content = preg_replace([
    //         '/[\x{2018}\x{2019}]/u',
    //         '/[\x{201C}\x{201D}]/u',
    //         '/\x{2026}/u',
    //         '/[\x{2013}\x{2014}]/u'
    //     ], [
    //         "'",
    //         '"',
    //         '...',
    //         '-'
    //     ], $content);

    //     if (preg_match('/(We Chase Talents For Industry|Barthélemy GILLES).*$/s', $content, $matches)) {
    //         $mainContent = substr($content, 0, strpos($content, $matches[0]));
    //         $signatureBlock = $matches[0];

    //         $mainHtml = $this->processMainContentForPreview($mainContent);
    //         $signatureHtml = $this->processSignatureBlockForPreview($signatureBlock);

    //         return $mainHtml . $signatureHtml;
    //     }

    //     return $this->processMainContentForPreview($content);
    // }

    // private function processMainContentForPreview($content)
    // {
    //     $lines = explode("\n", $content);
    //     $formattedHtml = '<div style="margin: 0; padding: 0; line-height: 1.4;">';
    //     $inList = false;
    //     $currentParagraph = '';

    //     foreach ($lines as $line) {
    //         $line = trim($line);

    //         if (empty($line)) {
    //             if ($inList) {
    //                 $formattedHtml .= '</ul>';
    //                 $inList = false;
    //             } elseif (!empty($currentParagraph)) {
    //                 $formattedHtml .= '<p style="margin: 0 0 10px 0; padding: 0; line-height: 1.4;">' . $this->formatTextForPreview($currentParagraph) . '</p>';
    //                 $currentParagraph = '';
    //             }
    //             continue;
    //         }

    //         if (preg_match('/^[-*•·]\s+(.*)/', $line, $matches)) {
    //             if (!empty($currentParagraph)) {
    //                 $formattedHtml .= '<p style="margin: 0 0 10px 0; padding: 0; line-height: 1.4;">' . $this->formatTextForPreview($currentParagraph) . '</p>';
    //                 $currentParagraph = '';
    //             }

    //             if (!$inList) {
    //                 $formattedHtml .= '<ul style="margin: 0 0 10px 0; padding-left: 20px;">';
    //                 $inList = true;
    //             }

    //             $listItem = $this->formatTextForPreview($matches[1]);
    //             $formattedHtml .= '<li style="margin: 0; padding: 0;">' . $listItem . '</li>';
    //         } else {
    //             if ($inList) {
    //                 $formattedHtml .= '</ul>';
    //                 $inList = false;
    //             }

    //             if (!empty($currentParagraph)) {
    //                 $currentParagraph .= ' ' . $line;
    //             } else {
    //                 $currentParagraph = $line;
    //             }
    //         }
    //     }

    //     if ($inList) {
    //         $formattedHtml .= '</ul>';
    //     } elseif (!empty($currentParagraph)) {
    //         $formattedHtml .= '<p style="margin: 0 0 10px 0; padding: 0; line-height: 1.4;">' . $this->formatTextForPreview($currentParagraph) . '</p>';
    //     }

    //     $formattedHtml .= '</div>';
    //     return $formattedHtml;
    // }

    // private function processSignatureBlockForPreview($content)
    // {
    //     $html = '<p>';

    //     if (stripos($content, 'Bien à vous') !== false) {
    //         $html .= 'Bien à vous,<br>';
    //     }

    //     $html .= '<br>';
    //     $html .= '<strong style="color:#161179;">Barthélemy GILLES</strong><br>';

    //     if (stripos($content, 'PH Div. Manager') !== false) {
    //         $html .= '<span style="color:#161179;">PH Div. Manager<br>Cell : 06 88 38 63 62</span>';
    //     }

    //     $html .= '<br>';

    //     $html .= '<img src="https://mail.google.com/mail/u/0?ui=2&ik=ba40943ee4&attid=0.1&permmsgid=msg-f:1834025678819356517&th=1973c4a346f8ef65&view=fimg&fur=ip&permmsgid=msg-f:1834025678819356517&sz=s0-l75-ft&attbid=ANGjdJ8vcZojToE387HMzqNJgznXrBe5PLYsrrvz99-781TrKJO7sCv-eV01icxbInIMAfV9zi1CtFUvtxo8mUr3f4GPB33alhvshPg_n4UaPnXmOUxioWaKuPj27C8&disp=emb&zw" alt="Harmen & Botts Logo" style="height:40px; margin:10px 0;"><br>';


    //     // For preview, show placeholder instead of actual logo
    //     // $html .= '<div style="background-color: #f0f0f0; border: 1px dashed #ccc; padding: 10px; text-align: center; margin: 10px 0; font-style: italic; color: #666;">Logo will appear here in actual email</div>';

    //     $html .= '<strong style="color:#161179;"><em>We Chase Talents For Industry</em></strong><br>';

    //     if (stripos($content, 'Avenue du Roule') !== false) {
    //         $html .= '<span style="color:#161179;">37, Avenue du Roule<br></span>';
    //     }

    //     if (stripos($content, 'Neuilly-sur-Seine') !== false) {
    //         $html .= '<span style="color:#161179;">92200 Neuilly-sur-Seine<br>Std : 01 84 20 46 49<br></span>';
    //     }

    //     $html .= '<a style="color:#161179;" href="http://www.harmen-botts.com">www.harmen-botts.com</a>';
    //     $html .= '</p>';

    //     return $html;
    // }

    // private function formatTextForPreview($text)
    // {
    //     $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    //     $text = preg_replace('/__(.*?)__/', '<strong>$1</strong>', $text);
    //     $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
    //     $text = preg_replace('/_(.*?)_/', '<em>$1</em>', $text);

    //     $text = preg_replace('/\[(.*?)\]\{\.underline\}/', '<u>$1</u>', $text);

    //     // Updated patterns with dash prefix
    //     $boldPatterns = [
    //         'Nous couvrons la totalité des métiers' => '- <strong>Nous couvrons la totalité des métiers</strong>',
    //         'Nous sommes rapides et agiles' => '- <strong>Nous sommes rapides et agiles</strong>',
    //         'Nous sommes rigoureux et déterminés' => '- <strong>Nous sommes rigoureux et déterminés</strong>',
    //         'Nous développons nos propres solutions' => '- <strong>Nous développons nos propres solutions</strong>',
    //         'Barthélemy GILLES' => '<strong>Barthélemy GILLES</strong>'
    //     ];

    //     foreach ($boldPatterns as $pattern => $replacement) {
    //         $text = str_replace($pattern, $replacement, $text);
    //     }

    //     $text = str_replace('Ce qui nous caractérise', '<u>Ce qui nous caractérise</u>', $text);

    //     return $text;
    // }










    public function edit($id)
    {
        $this->isEditing = true;
        $this->editId = $id;

        $entry = Mcpdashboard::find($id);

        if ($entry) {
            $this->date_mcp = $entry->date_mcp;
            $this->mcp_code = $entry->mcp_code;
            $this->designation = $entry->designation;
            $this->object = $entry->object;
            $this->tag_source = $entry->tag_source;
            $this->message = $entry->message;
            $this->tool = $entry->tool;
            $this->remarks = $entry->remarks;
            $this->notes = $entry->notes;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'date_mcp',
            'mcp_code',
            'designation',
            'object',
            'tag_source',
            'message',
            'tool',
            'recip_list_path',
            'message_doc',
            'attachments',
            'from',
            'subject',
            'launch_date',
            'pause_min',
            'pause_max',
            'batch_min',
            'batch_max',
            'work_time_start',
            'work_time_end',
            'ref_time',
            'status',
            'status_date',
            'target_status',
            'remarks',
            'notes'
        ]);

        $this->isEditing = false;
        $this->editId = null;
        $this->date_mcp = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.mcpform.index');
    }
}