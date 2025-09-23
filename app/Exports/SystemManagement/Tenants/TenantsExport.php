<?php

// Namspace
namespace App\Exports\SystemManagement\Tenants;

// Excel Library
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Main class
class TenantsExport implements FromCollection, WithHeadings, WithStyles
{
    // Table
    protected $tenants;

    // Array
    public function __construct(Collection $tenants)
    {
        $this->tenants = $tenants;
    }

    // Rows
    public function collection()
    {
        return $this->tenants->values()->map(function ($tenant, $index) {
            return [
                $index + 1,
                $tenant->name,
                $tenant->logo ?: __('global.no_image'),
                $tenant->state_text,
                $tenant->created_at->format('Y-m-d H:i:s'),
                $tenant->creator->name ?? '-',
            ];
        });
    }

    // Columns
    public function headings(): array
    {
        return [
            __('tenants.id'),
            __('tenants.name'),
            __('tenants.logo'),
            __('tenants.is_active'),
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
