<?php

namespace App\Exports;

use App\Models\Trgdashboard;
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

class TrgdashboardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Trgdashboard::query(); // Use query() instead of all()
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Creation Date',
            'Company',
            'Standard Phone',
            'Postal Code Department',
            'Title',
            'First Name',
            'Last Name',
            'Position',
            'Email',
            'Mobile',
            'Event Date',
            'Type',
            'Subject',
            'Event Status',
            'Comment TRG',
            'Next Step',
            'Updated At',
            'Created At',
            'Auth',
            'Address One',
            'Website URL',
            'TRG Code',
            'Address',
            'Region',
            'Town',
            'Country',
            'CA K',
            'Employees',
            'Activity',
            'SIRET',
            'RCS',
            'Filiation',
            'OFF',
            'Legal Form',
            'VAT Number',
            'TRG Status',
            'Remarks',
            'Notes',
            'Last Modification Date',
            'Priority',
        ];
    }

    /**
     * Map data for each row
     */
    public function map($trgdashboard): array
    {
        return [
            $trgdashboard->id,
            $trgdashboard->creation_date,
            $trgdashboard->company,
            $trgdashboard->standard_phone,
            $trgdashboard->postal_code_department,
            $trgdashboard->title,
            $trgdashboard->first_name,
            $trgdashboard->last_name,
            $trgdashboard->position,
            $trgdashboard->email,
            $trgdashboard->mobile,
            $trgdashboard->event_date,
            $trgdashboard->type,
            $trgdashboard->subject,
            $trgdashboard->event_status,
            $trgdashboard->comment_trg,
            $trgdashboard->next_step,
            $trgdashboard->updated_at,
            $trgdashboard->created_at,
            $trgdashboard->auth,
            $trgdashboard->address_one,
            $trgdashboard->website_url,
            $trgdashboard->trg_code,
            $trgdashboard->address,
            $trgdashboard->region,
            $trgdashboard->town,
            $trgdashboard->country,
            $trgdashboard->ca_k,
            $trgdashboard->employees,
            $trgdashboard->activity,
            $trgdashboard->siret,
            $trgdashboard->rcs,
            $trgdashboard->filiation,
            $trgdashboard->off,
            $trgdashboard->legal_form,
            $trgdashboard->vat_number,
            $trgdashboard->trg_status,
            $trgdashboard->remarks,
            $trgdashboard->notes,
            $trgdashboard->last_modification_date,
            $trgdashboard->priority,

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


