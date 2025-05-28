<?php

namespace App\Livewire\Back\Cres;

use Livewire\Component;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class Show extends Component
{
    public $candidate;

    public function generatePdf()
    {
        $html = view('livewire.back.cres.pdf', [
            'cres' => $this->candidate->cres,
            'candidate' => $this->candidate,
        ])->render();

        $dompdf = new Dompdf();
        
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $pdfFileName = uniqid('pdf_') . '.pdf';
        Storage::put('public/'.$pdfFileName, $dompdf->output());

       
        $pdfName = 'CRE ' . $this->candidate->first_name . '_' . $this->candidate->last_name . '.pdf';

        return response()->download(storage_path('app/public/'.$pdfFileName), $pdfName)->deleteFileAfterSend(true);
    }

    public function render()
    {
        $cres = $this->candidate->cres;
        return view('livewire.back.cres.show')->with([
            'cres' => $cres,
        ]);
    }
}
