<?php

namespace App\Exports;

use App\Models\Mcpdashboard;
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

class McpdashboardExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithChunkReading
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Mcpdashboard::query(); // Use query() instead of all()
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date MCP',
            'MCP Code',
            'Designation',
            'Object',
            'Tag Source',
            'Message',
            'Tool',
            'Remarks',
            'Notes',
            'Created At',
            'Updated At',
            'Recipient List Path',
            'Subject',
            'Message Doc',
            'Attachments',
            'From Email',
            'Launch Date',
            'Work Time Start',
            'Work Time End',
            'Pause Min',
            'Pause Max',
            'Batch Min',
            'Batch Max',
            'Ref Time',
            'Target Status',
            'Status',
            'Total Mails',
            'Success Count',
            'Fails Count',
            'Status Date',
        ];
    }

    /**
     * Map data for each row
     */
    public function map($mcpdashboard): array
    {
        return [
            $mcpdashboard->id,
            $mcpdashboard->date_mcp,
            $mcpdashboard->mcp_code,
            $mcpdashboard->designation,
            $mcpdashboard->object,
            $mcpdashboard->tag_source,
            $mcpdashboard->message,
            $mcpdashboard->tool,
            $mcpdashboard->remarks,
            $mcpdashboard->notes,
            $mcpdashboard->created_at,
            $mcpdashboard->updated_at,
            $mcpdashboard->recip_list_path,
            $mcpdashboard->subject,
            $mcpdashboard->message_doc,
            $mcpdashboard->attachments,
            $mcpdashboard->from_email,
            $mcpdashboard->launch_date,
            $mcpdashboard->work_time_start,
            $mcpdashboard->work_time_end,
            $mcpdashboard->pause_min,
            $mcpdashboard->pause_max,
            $mcpdashboard->batch_min,
            $mcpdashboard->batch_max,
            $mcpdashboard->ref_time,
            $mcpdashboard->target_status,
            $mcpdashboard->status,
            $mcpdashboard->total_mails,
            $mcpdashboard->success_count,
            $mcpdashboard->fails_count,
            $mcpdashboard->status_date,
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
