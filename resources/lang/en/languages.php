<?php

return [
    'singular'        => 'Language',
    'plural'          => 'Languages',

    'index_title'     => 'Language List',
    'create_title'    => 'Language - Create',
    'show_title'      => 'Language - Details',
    'edit_title'      => 'Language - Edit',
    'delete_title'    => 'Language - Delete',
    'live_edit_title' => 'Language - Edit All',
    'edit_all_title'  => 'Language - Edit All',
    'edit_all'        => 'Edit All',
    'view_list'       => 'View List',
    'id'              => 'No.',
    'name'            => 'Name',
    'is_active'       => 'Status',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Name (editable)',
        'editable_status' => 'Status (editable)',
    ],

    // Status options
    'status_options' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    // Actions
    'actions' => [
        'back' => 'Back',
    ],

    // Export
    'export_filename' => 'languages_export',
    'pdf_title' => 'Languages List',
    'pdf_subtitle' => 'Generated on',

    // Validation messages
    'name_required' => 'The name field is required.',
    'name_unique' => 'This language name already exists.',
    'is_active_required' => 'The status field is required.',
    'deleted_description_required' => 'The deletion reason is required.',
    'deleted_description_min' => 'The deletion reason must be at least 3 characters.',
    'deleted_description_max' => 'The deletion reason cannot exceed 1000 characters.',
];