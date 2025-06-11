<?php

namespace App\Imports;

use App\Models\Oppdashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class OppdashboardImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date conversion
        $opportunity_date = null;
        if (!empty($row['opportunity_date'])) {
            try {
                // Try different date formats
                if (is_numeric($row['opportunity_date'])) {
                    // Excel serial date
                    $opportunity_date = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['opportunity_date'] - 2)->format('Y-m-d');
                } else {
                    // Try parsing as string
                    $opportunity_date = Carbon::parse($row['opportunity_date'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $opportunity_date = null;
            }
        }

        return new Oppdashboard([
            'opportunity_date' => $opportunity_date,
            'opp_code' => $row['opp_code'] ?? null,
            'job_titles' => $row['job_titles'] ?? null,
            'name' => $row['name'] ?? null,
            'postal_code_1' => $row['postal_code_1'] ?? null,
            'site_city' => $row['site_city'] ?? null,
            'opportunity_status' => $row['opportunity_status'] ?? null,
            'remarks' => $row['remarks'] ?? null,
            'trg_code' => $row['trg_code'] ?? null,
            'total_paid' => $row['total_paid'] ?? null,
            'created_at' => $row['created_at'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
            'auth' => $row['auth'] ?? null,
            'ctc1_code' => $row['ctc1_code'] ?? null,
            'civs' => $row['civs'] ?? null,
            'ctc1_first_name' => $row['ctc1_first_name'] ?? null,
            'ctc1_last_name' => $row['ctc1_last_name'] ?? null,
            'position' => $row['position'] ?? null,
            'specificities' => $row['specificities'] ?? null,
            'domain' => $row['domain'] ?? null,
            'postal_code' => $row['postal_code'] ?? null,
            'town' => $row['town'] ?? null,
            'country' => $row['country'] ?? null,
            'experience' => $row['experience'] ?? null,
            'schooling' => $row['schooling'] ?? null,
            'schedules' => $row['schedules'] ?? null,
            'mobility' => $row['mobility'] ?? null,
            'permission' => $row['permission'] ?? null,
            'type' => $row['type'] ?? null,
            'vehicle' => $row['vehicle'] ?? null,
            'job_offer_date' => $row['job_offer_date'] ?? null,
            'skill_one' => $row['skill_one'] ?? null,
            'skill_two' => $row['skill_two'] ?? null,
            'skill_three' => $row['skill_three'] ?? null,
            'other_one' => $row['other_one'] ?? null,
            'remarks_two' => $row['remarks_two'] ?? null,
            'job_start_date' => $row['job_start_date'] ?? null,
            'invoice_date' => $row['invoice_date'] ?? null,
            'gross_salary' => $row['gross_salary'] ?? null,
            'bonus_1' => $row['bonus_1'] ?? null,
            'bonus_2' => $row['bonus_2'] ?? null,
            'bonus_3' => $row['bonus_3'] ?? null,
            'other_two' => $row['other_two'] ?? null,
            'date_emb' => $row['date_emb'] ?? null,
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
            '*.opp_code' => 'nullable|string|max:255',
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
