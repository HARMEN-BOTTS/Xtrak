<?php

namespace App\Exports;

use App\Models\Candidate;
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

class CdtdashboardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Candidate::query(); // Use query() instead of all()
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Phone 2',
            'City',
            'Address',
            'Region',
            'Country',
            'Postal Code',
            'Certificate',
            'Code CDT',
            'URL CTC',
            'Commentaire',
            'Origine',
            'Compagny ID',
            'Candidate Statut ID',
            'Disponibility ID',
            'Civ ID',
            'Position ID',
            'Field ID',
            'Speciality ID',
            'Created By',
            'Candidate State ID',
            'Next Step ID',
            'NS Date ID',
            'CRE Ref',
            'CRE Created At',
            'Created At',
            'Updated At',
            'Description',
            'Suivi',
        ];
    }

    /**
     * Map data for each row
     */
    public function map($candidate): array
    {
        return [
            $candidate->id,
            $candidate->first_name,
            $candidate->last_name,
            $candidate->email,
            $candidate->phone,
            $candidate->phone_2,
            $candidate->city,
            $candidate->address,
            $candidate->region,
            $candidate->country,
            $candidate->postal_code,
            $candidate->certificate,
            $candidate->code_cdt,
            $candidate->url_ctc,
            $candidate->commentaire,
            $candidate->origine,
            $candidate->compagny_id,
            $candidate->candidate_statut_id,
            $candidate->disponibility_id,
            $candidate->civ_id,
            $candidate->position_id,
            $candidate->field_id,
            $candidate->speciality_id,
            $candidate->created_by,
            $candidate->candidate_state_id,
            $candidate->next_step_id,
            $candidate->ns_date_id,
            $candidate->cre_ref,
            $candidate->cre_created_at,
            $candidate->created_at,
            $candidate->updated_at,
            $candidate->description,
            $candidate->suivi,
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
