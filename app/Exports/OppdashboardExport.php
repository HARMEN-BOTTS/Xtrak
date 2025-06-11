<?php

namespace App\Exports;

use App\Models\Oppdashboard;
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

class OppdashboardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Oppdashboard::query(); // Use query() instead of all()
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Opportunity Date',
            'Opportunity Code',
            'Job Titles',
            'Name',
            'Postal Code 1',
            'Site City',
            'Opportunity Status',
            'Remarks',
            'TRG Code',
            'Total Paid',
            'Created At',
            'Updated At',
            'Auth',
            'CTC1 Code',
            'CIVS',
            'CTC1 First Name',
            'CTC1 Last Name',
            'Position',
            'Specificities',
            'Domain',
            'Postal Code',
            'Town',
            'Country',
            'Experience',
            'Schooling',
            'Schedules',
            'Mobility',
            'Permission',
            'Type',
            'Vehicle',
            'Job Offer Date',
            'Skill One',
            'Skill Two',
            'Skill Three',
            'Other One',
            'Remarks Two',
            'Job Start Date',
            'Invoice Date',
            'Gross Salary',
            'Bonus 1',
            'Bonus 2',
            'Bonus 3',
            'Other Two',
            'Date EMB'
        ];
    }

    /**
     * Map data for each row
     */
    public function map($oppdashboard): array
    {
        return [
            $oppdashboard->id,
            $oppdashboard->opportunity_date,
            $oppdashboard->opp_code,
            $oppdashboard->job_titles,
            $oppdashboard->name,
            $oppdashboard->postal_code_1,
            $oppdashboard->site_city,
            $oppdashboard->opportunity_status,
            $oppdashboard->remarks,
            $oppdashboard->trg_code,
            $oppdashboard->total_paid,
            $oppdashboard->created_at,
            $oppdashboard->updated_at,
            $oppdashboard->auth,
            $oppdashboard->ctc1_code,
            $oppdashboard->civs,
            $oppdashboard->ctc1_first_name,
            $oppdashboard->ctc1_last_name,
            $oppdashboard->position,
            $oppdashboard->specificities,
            $oppdashboard->domain,
            $oppdashboard->postal_code,
            $oppdashboard->town,
            $oppdashboard->country,
            $oppdashboard->experience,
            $oppdashboard->schooling,
            $oppdashboard->schedules,
            $oppdashboard->mobility,
            $oppdashboard->permission,
            $oppdashboard->type,
            $oppdashboard->vehicle,
            $oppdashboard->job_offer_date,
            $oppdashboard->skill_one,
            $oppdashboard->skill_two,
            $oppdashboard->skill_three,
            $oppdashboard->other_one,
            $oppdashboard->remarks_two,
            $oppdashboard->job_start_date,
            $oppdashboard->invoice_date,
            $oppdashboard->gross_salary,
            $oppdashboard->bonus_1,
            $oppdashboard->bonus_2,
            $oppdashboard->bonus_3,
            $oppdashboard->other_two,
            $oppdashboard->date_emb,

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
