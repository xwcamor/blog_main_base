<?php

// Namespace
namespace App\Exports\SystemManagement\Tenants;

// Word Library
use PhpOffice\PhpWord\TemplateProcessor;

// Main class
class TenantsWord
{
    // Generate Word
    public function generate($tenants, string $filename): void
    {
        // Create template
        $template = new TemplateProcessor(
            resource_path('templates/system_management/tenants/template.docx')
        );

        // Title and date
        $template->setValue('title',  __('tenants.export_title'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        // Columns
        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('tenants.name'));
        $template->setValue('header_logo', __('tenants.logo'));
        $template->setValue('header_state', __('tenants.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        // Rows
        $template->cloneRow('no', count($tenants));
        foreach ($tenants as $i => $tenant) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $tenant->name);
            $template->setValue("logo#{$row}", $tenant->logo ?: __('global.no_image'));
            $template->setValue("state#{$row}", $tenant->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($tenant->created_at));
            $template->setValue("creator#{$row}", $tenant->creator->name ?? '-');
        }

        // Save to provided path
        $template->saveAs($filename);
    }
}
