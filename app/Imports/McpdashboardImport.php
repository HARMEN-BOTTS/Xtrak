<?php

namespace App\Imports;

use App\Models\Mcpdashboard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class McpdashboardImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Handle date conversion
        $date_mcp = null;
        if (!empty($row['date_mcp'])) {
            try {
                // Try different date formats
                if (is_numeric($row['date_mcp'])) {
                    // Excel serial date
                    $date_mcp = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['date_mcp'] - 2)->format('Y-m-d');
                } else {
                    // Try parsing as string
                    $date_mcp = Carbon::parse($row['date_mcp'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $date_mcp = null;
            }
        }

        return new Mcpdashboard([
            'date_mcp' => $date_mcp,
            'mcp_code' => $row['mcp_code'] ?? null,
            'designation' => $row['designation'] ?? null,
            'object' => $row['object'] ?? null,
            'tag_source' => $row['tag_source'] ?? null,
            'message' => $row['message'] ?? null,
            'tool' => $row['tool'] ?? null,
            'remarks' => $row['remarks'] ?? null,
            'notes' => $row['notes'] ?? null,
            'created_at' => $row['created_at'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
            'recip_list_path' => $row['recip_list_path'] ?? null,
            'subject' => $row['subject'] ?? null,
            'message_doc' => $row['message_doc'] ?? null,
            'attachments' => $row['attachments'] ?? null,
            'from_email' => $row['from_email'] ?? null,
            'launch_date' => $row['launch_date'] ?? null,
            'work_time_start' => $row['work_time_start'] ?? null,
            'work_time_end' => $row['work_time_end'] ?? null,
            'pause_min' => $row['pause_min'] ?? null,
            'pause_max' => $row['pause_max'] ?? null,
            'batch_min' => $row['batch_min'] ?? null,
            'batch_max' => $row['batch_max'] ?? null,
            'ref_time' => $row['ref_time'] ?? null,
            'target_status' => $row['target_status'] ?? null,
            'status' => $row['status'] ?? null,
            'total_mails' => $row['total_mails'] ?? null,
            'success_count' => $row['success_count'] ?? null,
            'fails_count' => $row['fails_count'] ?? null,
            'status_date' => $row['status_date'] ?? null,
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
            '*.mcp_code' => 'nullable|string|max:255',
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
