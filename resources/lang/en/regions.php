<?php

return [
    // Titles
    'singular'        => 'Region',
    'plural'          => 'Regions',

    // Columns
    'index_title'     => 'Regions List',
    'create_title'    => 'Region - Create',
    'show_title'      => 'Region - Information',
    'edit_title'      => 'Region - Edit',
    'delete_title'    => 'Region - Delete',
    'edit_all_title'  => 'Region - Edit All',
    'id'              => 'No.',
    'name'            => 'Name',
    'is_active'       => 'Status',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Name (editable)',
        'editable_status' => 'Status (editable)',
    ],

    // Export
    'export_filename' => 'regions_export',
    'export_title'    => 'Regions Report',

    // Validation messages
    // name
    'name_required' => 'The name field is required.',
    'name_unique'   => 'This region already exists.',

    // is_active
    'is_active_required' => 'The status field is required.',

    // deletion
    'deleted_description_required' => 'The deletion reason is required.',
    'deleted_description_min'      => 'The deletion reason must be at least 3 characters.',
    'deleted_description_max'      => 'The deletion reason cannot exceed 1000 characters.',
];
