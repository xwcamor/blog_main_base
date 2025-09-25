<?php

return [
    // Titles
    'singular'        => 'Tenant',
    'plural'          => 'Tenants',

    // Columns
    'index_title'     => 'Tenants List',
    'create_title'    => 'Tenant - Create',
    'show_title'      => 'Tenant - Information',
    'edit_title'      => 'Tenant - Edit',
    'delete_title'    => 'Tenant - Delete',
    'edit_all_title'  => 'Tenant - Edit All',
    'id'              => 'No.',
    'name'            => 'Name',
    'logo'            => 'Logo',
    'api_key'         => 'API Key',
    'is_active'       => 'Status',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Name (editable)',
        'editable_status' => 'Status (editable)',
    ],

    // Export
    'export_filename' => 'tenants_export',
    'export_title'    => 'Tenants Report',

    // Validation messages
    // name
    'name_required' => 'The name field is required.',
    'name_unique'   => 'This tenant already exists.',

    // logo
    'logo_image' => 'The logo must be an image file.',
    'logo_mimes' => 'The logo must be a file of type: jpg, jpeg, png, webp.',
    'logo_max'   => 'The logo may not be greater than 2MB.',

    // is_active
    'is_active_required' => 'The status field is required.',

    // deletion
    'deleted_description_required' => 'The deletion reason is required.',
    'deleted_description_min'      => 'The deletion reason must be at least 3 characters.',
    'deleted_description_max'      => 'The deletion reason cannot exceed 1000 characters.',
];