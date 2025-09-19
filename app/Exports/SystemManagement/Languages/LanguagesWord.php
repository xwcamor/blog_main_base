<?php

// Namspace
namespace App\Exports\SystemManagement\Languages;

// Word Library
use PhpOffice\PhpWord\TemplateProcessor;

// Main class
class LanguagesWord
{
    public function generate($languages, $filename)
    {
        // Create template
        $template = new TemplateProcessor(
            resource_path('templates/system_management/languages/template.docx')
            
        );

        // Title and date
        $template->setValue('title',  __('languages.export_title'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        // Columns
        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('languages.name'));
        $template->setValue('header_iso_code', __('languages.iso_code'));
        $template->setValue('header_state', __('languages.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        // CRows
        $template->cloneRow('no', count($languages));

        foreach ($languages as $i => $language) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $language->name);
            $template->setValue("iso_code#{$row}", $language->iso_code);
            $template->setValue("state#{$row}", $language->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($language->created_at));
            $template->setValue("creator#{$row}", $language->creator->name ?? '-');
        }
        
        // Create file
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $template->saveAs($tempFile);
        
        // Download file
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}