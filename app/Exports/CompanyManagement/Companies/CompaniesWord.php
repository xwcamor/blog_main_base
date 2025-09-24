<?php

// Namespace
namespace App\Exports\CompanyManagement\Companies;

// Word Library
use PhpOffice\PhpWord\TemplateProcessor;

// Main class
class CompaniesWord
{
    // Generate Word
    public function generate($companies, string $filename): void
    {
        // Create template
        $template = new TemplateProcessor(
            resource_path('templates/company_management/companies/template.docx')
        );

        // Title and date
        $template->setValue('title',  __('companies.export_title'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        // Columns
        $template->setValue('header_no', 'No');
        $template->setValue('header_ruc', 'RUC');
        $template->setValue('header_razon_social', 'Razón Social');
        $template->setValue('header_direccion', 'Dirección');
        $template->setValue('header_num_doc', 'Número de Documento');

        // Rows
        $template->cloneRow('no', count($companies));
        foreach ($companies as $i => $company) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("ruc#{$row}", $company->ruc);
            $template->setValue("razon_social#{$row}", $company->razon_social);
            $template->setValue("direccion#{$row}", $company->direccion);
            $template->setValue("num_doc#{$row}", $company->num_doc);
        }

        // Save to provided path
        $template->saveAs($filename);
    }
}