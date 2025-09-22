<?php

// Using Namespace from app\Pdfs
namespace App\Pdfs\SystemManagement;

// Using Pdf Support
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

// Main class
class SystemModulesPdf
{
    public function generate(Collection $system_modules, string $filename)
    {
        $pdf = Pdf::loadView('system_management.system_modules.pdf.template', compact('system_modules'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->download($filename);
    }
}