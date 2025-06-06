<?php

namespace App\Exports;

use App\Models\Ctcdashboard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CtcdashboardExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Ctcdashboard::all();
    }

    /**
     * Define headings for the export
     */
    public function headings(): array
    {
        return [
            'ID',
            'Date CTC',
            'Company CTC',
            'Civ',
            'First Name',
            'Last Name',
            'Function CTC',
            'STD CTC',
            'EXT CTC',
            'LD',
            'Cell',
            'Mail',
            'CTC Code',
            'TRG Code',
            'Remarks',
            'Notes',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map data for each row
     */
    public function map($ctcdashboard): array
    {
        return [
            $ctcdashboard->id,
            $ctcdashboard->date_ctc,
            $ctcdashboard->company_ctc,
            $ctcdashboard->civ,
            $ctcdashboard->first_name,
            $ctcdashboard->last_name,
            $ctcdashboard->function_ctc,
            $ctcdashboard->std_ctc,
            $ctcdashboard->ext_ctc,
            $ctcdashboard->ld,
            $ctcdashboard->cell,
            $ctcdashboard->mail,
            $ctcdashboard->ctc_code,
            $ctcdashboard->trg_code,
            $ctcdashboard->remarks,
            $ctcdashboard->notes,
            $ctcdashboard->created_at,
            $ctcdashboard->updated_at,
        ];
    }

    /**
     * Column formatting
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Date CTC column
            'K' => NumberFormat::FORMAT_TEXT, // Cell column (to preserve leading zeros)
            'L' => NumberFormat::FORMAT_TEXT, // Mail column
        ];
    }
}