<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class BatchesExport implements FromCollection, WithHeadings, WithEvents
{
    protected $batches;
    protected $settings;

    public function __construct($batches, $settings)
    {
        $this->batches = $batches;
        $this->settings = $settings;
    }

    public function collection()
    {
        return $this->batches->map(function ($batch) {
            return [
                'Batch #'        => $batch->batch_number,
                'Dispatched By'  => $batch->dispatched_by,
                'Dispatched At'  => $batch->dispatched_at ? $batch->dispatched_at->format('d M Y, h:i A') : 'N/A',
                'Total Parcels'  => $batch->parcels_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Batch #',
            'Dispatched By',
            'Dispatched At',
            'Total Parcels',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $settings = $this->settings;

                // ✅ Company details header
                $sheet->setCellValue('A1', $settings->company_name ?? 'Company Name');
                $sheet->setCellValue('A2', 'Email: ' . ($settings->email ?? 'N/A'));
                $sheet->setCellValue('A3', 'Phone: ' . ($settings->phone ?? 'N/A'));
                $sheet->setCellValue('A4', 'Address: ' . ($settings->street_address ?? 'N/A'));
                $sheet->setCellValue('A6', 'Dispatched Batches Report');
            },
        ];
    }
}
