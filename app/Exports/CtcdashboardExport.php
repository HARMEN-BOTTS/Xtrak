<?php

namespace App\Exports;

use App\Models\Ctcdashboard;
// Change FromCollection to FromQuery
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// Add these new concerns
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CtcdashboardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Ctcdashboard::query(); // Use query() instead of all()
    }

    public function chunkSize(): int
    {
        return 5000;
    }
  
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