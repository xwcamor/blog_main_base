<?php

return [
    // Titles
    'singular'        => 'Module',
    'plural'          => 'Modules',
    
    // Columns
    'index_title'     => 'Module List',
    'create_title'    => 'Module - Create',
    'show_title'      => 'Module - Details',
    'edit_title'      => 'Module - Edit',
    'delete_title'    => 'Module - Delete',
    'edit_all_title'  => 'Module - Edit All',
    'id'              => 'No.',
    'name'            => 'Name',
    'permission_key'  => 'Permission Key',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Name (editable)',
        'editable_status' => 'Status (editable)',
    ],

    // Export
    'export_filename' => 'modules_export',
    'export_title'    => 'Modules Report',

    // Validation messages
    // name
    'name_required' => 'The module name field is required.',
    'name_unique'   => 'This module name already exists.',

    // uso_code
    'permission_key_required' => 'The permission key field is required.',
    'permission_key_unique'   => 'This permission key already exists.',

     // deletion
    'deleted_description_required' => 'The deletion reason is required.',
    'deleted_description_min' => 'The deletion reason must be at least 3 characters.',
    'deleted_description_max' => 'The deletion reason cannot exceed 1000 characters.',
];