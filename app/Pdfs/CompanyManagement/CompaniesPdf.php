<?php

namespace App\Pdfs\CompanyManagement;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class CompaniesPdf
{
    public function generate(Collection $companies, string $filename)
    {
        $pdf = Pdf::loadView('company_management.companies.pdf.template', compact('companies'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->download($filename); // Fuerza la descarga inmediata
    }
}
