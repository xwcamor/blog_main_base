<?php

return [
    // Titles
    'singular'        => 'Región',
    'plural'          => 'Regiones',

    // Columns
    'index_title'     => 'Listado de Regiones',
    'create_title'    => 'Región - Crear',
    'show_title'      => 'Región - Información',
    'edit_title'      => 'Región - Editar',
    'delete_title'    => 'Región - Eliminar',
    'edit_all_title'  => 'Región - Editar Todo',
    'id'              => 'N°',
    'name'            => 'Nombre',
    'is_active'       => 'Estado',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Nombre (editable)',
        'editable_status' => 'Estado (editable)',
    ],

    // Export
    'export_filename' => 'exportación_regiones',
    'export_title'    => 'Reporte de Regiones',

    // Validation messages
    // name
    'name_required' => 'El campo nombre es obligatorio.',
    'name_unique'   => 'Esta región ya existe.',

    // is_active
    'is_active_required' => 'El campo estado es obligatorio.',

    // deletion
    'deleted_description_required' => 'El motivo de eliminación es obligatorio.',
    'deleted_description_min'      => 'El motivo de eliminación debe tener al menos 3 caracteres.',
    'deleted_description_max'      => 'El motivo de eliminación no puede superar los 1000 caracteres.',
];
