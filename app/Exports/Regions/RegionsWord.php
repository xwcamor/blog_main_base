<?php

// Namespace
namespace App\Exports\SystemManagement\Regions;

// Word Library
use PhpOffice\PhpWord\TemplateProcessor;

// Main class
class RegionsWord
{
    // Generate Word
    public function generate($regions, string $filename): void
    {
        // Create template
        $template = new TemplateProcessor(
            resource_path('templates/system_management/regions/template.docx')
        );

        // Title and date
        $template->setValue('title',  __('regions.export_title'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        // Columns
        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('regions.name'));
        $template->setValue('header_state', __('regions.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        // Rows
        $template->cloneRow('no', count($regions));
        foreach ($regions as $i => $region) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $region->name);
            $template->setValue("state#{$row}", $region->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($region->created_at));
            $template->setValue("creator#{$row}", $region->creator->name ?? '-');
        }

        // Save to provided path
        $template->saveAs($filename);
    }
}
