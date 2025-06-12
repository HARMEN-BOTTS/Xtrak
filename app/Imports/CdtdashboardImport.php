<?php

namespace App\Imports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class CdtdashboardImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date conversion
        $created_at = null;
        if (!empty($row['created_at'])) {
            try {
                // Try different date formats
                if (is_numeric($row['created_at'])) {
                    // Excel serial date
                    $created_at = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['created_at'] - 2)->format('Y-m-d');
                } else {
                    // Try parsing as string
                    $created_at = Carbon::parse($row['created_at'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $created_at = null;
            }
        }

        return new Candidate([
            'created_at' => $created_at,
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'phone_2' => $row['phone_2'] ?? null,
            'city' => $row['city'] ?? null,
            'address' => $row['address'] ?? null,
            'region' => $row['region'] ?? null,
            'country' => $row['country'] ?? null,
            'postal_code' => $row['postal_code'] ?? null,
            'certificate' => $row['certificate'] ?? null,
            'code_cdt' => $row['code_cdt'] ?? null,
            'url_ctc' => $row['url_ctc'] ?? null,
            'commentaire' => $row['commentaire'] ?? null,
            'origine' => $row['origine'] ?? null,
            'compagny_id' => $row['compagny_id'] ?? null,
            'candidate_statut_id' => $row['candidate_statut_id'] ?? null,
            'disponibility_id' => $row['disponibility_id'] ?? null,
            'civ_id' => $row['civ_id'] ?? null,
            'position_id' => $row['position_id'] ?? null,
            'field_id' => $row['field_id'] ?? null,
            'speciality_id' => $row['speciality_id'] ?? null,
            'created_by' => $row['created_by'] ?? null,
            'candidate_state_id' => $row['candidate_state_id'] ?? null,
            'next_step_id' => $row['next_step_id'] ?? null,
            'ns_date_id' => $row['ns_date_id'] ?? null,
            'cre_ref' => $row['cre_ref'] ?? null,
            'cre_created_at' => $row['cre_created_at'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
            'description' => $row['description'] ?? null,
            'suivi' => $row['suivi'] ?? null,
        ]);
    }

    /**
     * Validation rules for each row
     */
    public function rules(): array
    {
        return [
            // '*.first_name' => 'required|string|max:255',
            // '*.last_name' => 'required|string|max:255',
            // '*.mail' => 'nullable|email|max:255',
            '*.code_cdt' => 'nullable|string|max:255',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            // '*.first_name.required' => 'First name is required',
            // '*.last_name.required' => 'Last name is required',
            // '*.mail.email' => 'Email must be a valid email address',
        ];
    }

    /**
     * Batch size for processing
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Chunk size for reading
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
