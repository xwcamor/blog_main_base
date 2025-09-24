<?php

// Namspace
namespace App\Exports\SystemManagement\Languages;

// Excel Library
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Main class
class LanguagesExport implements FromCollection, WithHeadings, WithStyles
{
    // Table
    protected $languages;
    
    // Array
    public function __construct(Collection $languages)
    {
        $this->languages = $languages;
    }
   
    // Rows
    public function collection()
    {
        return $this->languages->values()->map(function ($language, $index) {
            return [
                $index + 1,  
                $language->name,
                $language->iso_code,
                $language->state_text,
                $language->created_at->format('Y-m-d H:i:s'),
                $language->creator->name ?? '-',
            ];
        });
    }
    
    // Columns
    public function headings(): array
    {
        return [
            __('languages.id'),
            __('languages.name'),
            __('languages.iso_code'),
            __('languages.is_active'),
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