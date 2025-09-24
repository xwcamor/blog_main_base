<?php

// Namspace
namespace App\Exports\SystemManagement\SystemModules;

// Excel Library
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Main class
class SystemModulesExport implements FromCollection, WithHeadings, WithStyles
{
    // Table
    protected $system_modules;
    
    // Array
    public function __construct(Collection $system_modules)
    {
        $this->system_modules = $system_modules;
    }
   
    // Rows
    public function collection()
    {
        return $this->system_modules->values()->map(function ($system_module, $index) {
            return [
                $index + 1,  
                $system_module->name,
                $system_module->permission_key,
                $system_module->created_at->format('Y-m-d H:i:s'),
                $system_module->creator->name ?? '-',
            ];
        });
    }
    
    // Columns
    public function headings(): array
    {
        return [
            __('system_modules.id'),
            __('system_modules.name'),
            __('system_modules.permission_key'),
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