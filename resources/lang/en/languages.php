<?php

return [
    // Titles
    'singular'        => 'Language',
    'plural'          => 'Languages',
    
    // Columns
    'index_title'     => 'Language List',
    'create_title'    => 'Language - Create',
    'show_title'      => 'Language - Details',
    'edit_title'      => 'Language - Edit',
    'delete_title'    => 'Language - Delete',
    'edit_all_title'  => 'Language - Edit All',
    'id'              => 'No.',
    'name'            => 'Name',
    'iso_code'        => 'ISO 639-1',
    'is_active'       => 'Status',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Name (editable)',
        'editable_status' => 'Status (editable)',
    ],

    // Export
    'export_filename' => 'languages_export',
    'export_title'    => 'Languages Report',

    // Validation messages
    // name
    'name_required' => 'The name field is required.',
    'name_unique'   => 'This language name already exists.',

    // uso_code
    'iso_code_required' => 'The ISO code is required.',
    'iso_code_regex'    => 'The ISO code must be a valid format (e.g. es, en, pt_BR).',

     // is_active
    'is_active_required' => 'The status field is required.',
    
     // deletion
    'deleted_description_required' => 'The deletion reason is required.',
    'deleted_description_min' => 'The deletion reason must be at least 3 characters.',
    'deleted_description_max' => 'The deletion reason cannot exceed 1000 characters.',
];