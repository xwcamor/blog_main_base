<?php

// Using Namespace from app\Pdfs
namespace App\Pdfs\SystemManagement;

// Using Pdf Support
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

// Main class
class LanguagesPdf
{
    public function generate(Collection $languages, string $filename)
    {
        $pdf = Pdf::loadView('system_management.languages.pdf.template', compact('languages'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->download($filename);
    }
}