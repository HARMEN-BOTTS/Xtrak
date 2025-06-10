<?php

namespace App\Imports;

use App\Models\Ctcdashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class CtcdashboardImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date conversion
        $date_ctc = null;
        if (!empty($row['date_ctc'])) {
            try {
                // Try different date formats
                if (is_numeric($row['date_ctc'])) {
                    // Excel serial date
                    $date_ctc = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['date_ctc'] - 2)->format('Y-m-d');
                } else {
                    // Try parsing as string
                    $date_ctc = Carbon::parse($row['date_ctc'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $date_ctc = null;
            }
        }

        return new Ctcdashboard([
            'date_ctc' => $date_ctc,
            'company_ctc' => $row['company_ctc'] ?? null,
            'civ' => $row['civ'] ?? null,
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'function_ctc' => $row['function_ctc'] ?? null,
            'std_ctc' => $row['std_ctc'] ?? null,
            'ext_ctc' => $row['ext_ctc'] ?? null,
            'ld' => $row['ld'] ?? null,
            'cell' => $row['cell'] ?? null,
            'mail' => $row['mail'] ?? null,
            'ctc_code' => $row['ctc_code'] ?? null,
            'trg_code' => $row['trg_code'] ?? null,
            'remarks' => $row['remarks'] ?? null,
            'notes' => $row['notes'] ?? null,
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
            '*.mail' => 'nullable|email|max:255',
            '*.ctc_code' => 'nullable|string|max:255',
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
            '*.mail.email' => 'Email must be a valid email address',
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

