<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class ImportCandidatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;

    public function __construct($filePath, $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    public function handle()
    {
        $headers = [];
        $fileData = [];
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($this->filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                $rowData = $row->toArray();

                if ($rowIndex == 1) {
                    $headers = $rowData;
                    continue;
                }

                $fileData[] = $rowData;
            }
        }

        $reader->close();

        $batchSize = 1000;
        $chunks = array_chunk($fileData, $batchSize);

        foreach ($chunks as $chunk) {
            ProcessCandidateChunkJob::dispatch($chunk, $headers, $this->userId, $this->filePath);
        }
    }
}
