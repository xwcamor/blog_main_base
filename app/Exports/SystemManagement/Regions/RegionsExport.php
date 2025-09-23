<?php

// Namspace
namespace App\Exports\SystemManagement\Regions;

// Excel Library
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Main class
class RegionsExport implements FromCollection, WithHeadings, WithStyles
{
    // Table
    protected $regions;

    // Array
    public function __construct(Collection $regions)
    {
        $this->regions = $regions;
    }

    // Rows
    public function collection()
    {
        return $this->regions->values()->map(function ($region, $index) {
            return [
                $index + 1,
                $region->name,
                $region->state_text,
                $region->created_at->format('Y-m-d H:i:s'),
                $region->creator->name ?? '-',
            ];
        });
    }

    // Columns
    public function headings(): array
    {
        return [
            __('regions.id'),
            __('regions.name'),
            __('regions.is_active'),
            __('global.created_at'),
            __('global.created_by'),
        ];
    }

    // Styles
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
    }
}
