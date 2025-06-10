namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CtcdashboardTemplateExport implements WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    /**
     * Define headings for the template
     */
    public function headings(): array
    {
        return [
            'date_ctc',
            'company_ctc',
            'civ',
            'first_name',
            'last_name',
            'function_ctc',
            'std_ctc',
            'ext_ctc',
            'ld',
            'cell',
            'mail',
            'ctc_code',
            'trg_code',
            'remarks',
            'notes'
        ];
    }

    /**
     * Column formatting for template
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_YYYYMMDD, // date_ctc
            'J' => NumberFormat::FORMAT_TEXT, // cell
            'K' => NumberFormat::FORMAT_TEXT, // mail
        ];
    }
}