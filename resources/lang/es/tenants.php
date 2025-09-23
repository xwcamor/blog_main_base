<?php

return [
    // Titles
    'singular'        => 'Inquilino',
    'plural'          => 'Inquilinos',

    // Columns
    'index_title'     => 'Listado de Inquilinos',
    'create_title'    => 'Inquilino - Crear',
    'show_title'      => 'Inquilino - Información',
    'edit_title'      => 'Inquilino - Editar',
    'delete_title'    => 'Inquilino - Eliminar',
    'edit_all_title'  => 'Inquilino - Editar Todo',
    'id'              => 'N°',
    'name'            => 'Nombre',
    'logo'            => 'Logo',
    'is_active'       => 'Estado',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Nombre (editable)',
        'editable_status' => 'Estado (editable)',
    ],

    // Export
    'export_filename' => 'exportación_inquilinos',
    'export_title'    => 'Reporte de inquilinos',

    // Validation messages
    // name
    'name_required' => 'El campo nombre es obligatorio.',
    'name_unique'   => 'Este Inquilino ya existe.',

    // logo
    'logo_max' => 'El logo no puede superar los 255 caracteres.',

    // is_active
    'is_active_required' => 'El campo estado es obligatorio.',

    // deletion
    'deleted_description_required' => 'El motivo de eliminación es obligatorio.',
    'deleted_description_min'      => 'El motivo de eliminación debe tener al menos 3 caracteres.',
    'deleted_description_max'      => 'El motivo de eliminación no puede superar los 1000 caracteres.',
];
