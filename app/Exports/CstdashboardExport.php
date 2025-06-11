<?php

namespace App\Exports;

use App\Models\Cstdashboard;
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

class CstdashboardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Cstdashboard::query(); // Use query() instead of all()
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date CST',
            'CST Code',
            'Civ',
            'First Name',
            'Last Name',
            'Cell',
            'Mail',
            'Status',
            'Notes',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Map data for each row
     */
    public function map($cstdashboard): array
    {
        return [
            $cstdashboard->id,
            $cstdashboard->date_cst,
            $cstdashboard->cst_code,
            $cstdashboard->civ,
            $cstdashboard->first_name,
            $cstdashboard->last_name,
            $cstdashboard->cell,
            $cstdashboard->mail,
            $cstdashboard->status,
            $cstdashboard->notes,
            $cstdashboard->created_at,
            $cstdashboard->updated_at,
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
