<?php

namespace App\Exports\CompanyManagement\Companies;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompaniesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $companies;

    public function __construct(Collection $companies)
    {
        $this->companies = $companies;
    }

    // Filas
    public function collection()
    {
        return $this->companies->values()->map(function ($company, $index) {
            return [
                $index + 1,              // Número consecutivo
                $company->name,          // Nombre de la empresa
                $company->num_doc,       // Número de documento (RUC)
                $company->state_text,    // Estado activo/inactivo
                $company->created_at->format('Y-m-d H:i:s'),
                $company->creator->name ?? '-',
            ];
        });
    }

    // Encabezados
    public function headings(): array
    {
        return [
            __('companies.id'),
            __('companies.name'),
            __('companies.num_doc'),
            __('companies.is_active'),
            __('global.created_at'),
            __('global.created_by'),
        ];
    }

    // Estilos
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
