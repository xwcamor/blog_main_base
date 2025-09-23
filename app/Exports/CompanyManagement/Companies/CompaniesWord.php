<?php

namespace App\Exports\CompanyManagement\Companies;

use PhpOffice\PhpWord\TemplateProcessor;

class CompaniesWord
{
    public function generate($companies, $filename)
    {
        // Crear template
        $template = new TemplateProcessor(
            resource_path('templates/company_management/companies/template.docx')
        );

        // Título y fecha
        $template->setValue('title', __('companies.export_title'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        // Encabezados
        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('companies.name'));
        $template->setValue('header_num_doc', __('companies.num_doc'));
        $template->setValue('header_state', __('companies.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        // Filas
        $template->cloneRow('no', count($companies));

        foreach ($companies as $i => $company) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $company->name);
            $template->setValue("num_doc#{$row}", $company->num_doc);
            $template->setValue("state#{$row}", $company->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($company->created_at));
            $template->setValue("creator#{$row}", $company->creator->name ?? '-');
        }

        // Crear archivo temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $template->saveAs($tempFile);

        // Descargar archivo
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}
