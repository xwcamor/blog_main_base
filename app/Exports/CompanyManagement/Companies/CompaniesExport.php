<?php

// Namspace
namespace App\Exports\CompanyManagement\Companies;

// Excel Library
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Main class
class CompaniesExport implements FromCollection, WithHeadings, WithStyles
{
    // Table
    protected $companies;

    // Array
    public function __construct(Collection $companies)
    {
        $this->companies = $companies;
    }

    // Rows
    public function collection()
    {
        return $this->companies->values()->map(function ($company, $index) {
            return [
                $index + 1,
                $company->ruc,
                $company->direccion,
                $company->num_doc,
            ];
        });
    }

    // Columns
    public function headings(): array
    {
        return [
            __('companies.id'),
            __('companies.ruc'),
            __('companies.direccion'),
            __('companies.num_doc'),
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