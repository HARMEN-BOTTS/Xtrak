<?php

namespace App\Imports;

use App\Models\Trgdashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class TrgdashboardImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date conversion
        $creation_date = null;
        if (!empty($row['creation_date'])) {
            try {
                // Try different date formats
                if (is_numeric($row['creation_date'])) {
                    // Excel serial date
                    $creation_date = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['creation_date'] - 2)->format('Y-m-d');
                } else {
                    // Try parsing as string
                    $creation_date = Carbon::parse($row['creation_date'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $creation_date = null;
            }
        }

        return new Trgdashboard([
            'creation_date' => $creation_date,
            'company' => $row['company'] ?? null,
            'standard_phone' => $row['standard_phone'] ?? null,
            'postal_code_department' => $row['postal_code_department'] ?? null,
            'title' => $row['title'] ?? null,
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'position' => $row['position'] ?? null,
            'email' => $row['email'] ?? null,
            'mobile' => $row['mobile'] ?? null,
            'event_date' => $row['event_date'] ?? null,
            'type' => $row['type'] ?? null,
            'subject' => $row['subject'] ?? null,
            'event_status' => $row['event_status'] ?? null,
            'comment_trg' => $row['comment_trg'] ?? null,
            'next_step' => $row['next_step'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
            'created_at' => $row['created_at'] ?? null,
            'auth' => $row['auth'] ?? null,
            'address_one' => $row['address_one'] ?? null,
            'website_url' => $row['website_url'] ?? null,
            'trg_code' => $row['trg_code'] ?? null,
            'address' => $row['address'] ?? null,
            'region' => $row['region'] ?? null,
            'town' => $row['town'] ?? null,
            'country' => $row['country'] ?? null,
            'ca_k' => $row['ca_k'] ?? null,
            'employees' => $row['employees'] ?? null,
            'activity' => $row['activity'] ?? null,
            'siret' => $row['siret'] ?? null,
            'rcs' => $row['rcs'] ?? null,
            'filiation' => $row['filiation'] ?? null,
            'off' => $row['off'] ?? null,
            'legal_form' => $row['legal_form'] ?? null,
            'vat_number' => $row['vat_number'] ?? null,
            'trg_status' => $row['trg_status'] ?? null,
            'remarks' => $row['remarks'] ?? null,
            'notes' => $row['notes'] ?? null,
            'last_modification_date' => $row['last_modification_date'] ?? null,
            'priority' => $row['priority'] ?? null,
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
            '*.trg_code' => 'nullable|string|max:255',
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
