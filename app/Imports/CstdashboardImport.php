<?php

namespace App\Imports;

use App\Models\Cstdashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class CstdashboardImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date conversion
        $date_cst = null;
        if (!empty($row['date_cst'])) {
            try {
                // Try different date formats
                if (is_numeric($row['date_cst'])) {
                    // Excel serial date
                    $date_cst = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['date_cst'] - 2)->format('Y-m-d');
                } else {
                    // Try parsing as string
                    $date_cst = Carbon::parse($row['date_cst'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $date_cst = null;
            }
        }

        return new Cstdashboard([
            'date_cst' => $date_cst,
            'cst_code' => $row['cst_code'] ?? null,
            'civ' => $row['civ'] ?? null,
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'cell' => $row['cell'] ?? null,
            'mail' => $row['mail'] ?? null,
            'status' => $row['status'] ?? null,
            'notes' => $row['notes'] ?? null,
            'created_at' => $row['created_at'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
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
            '*.cst_code' => 'nullable|string|max:255',
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
