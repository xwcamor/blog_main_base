<?php

return [
    // Titles
    'singular'        => 'Módulo',
    'plural'          => 'Módulos',
    
    // Columns
    'index_title'     => 'Listado de Módulos',
    'create_title'    => 'Módulo - Crear',
    'show_title'      => 'Módulo - Información',
    'edit_title'      => 'Módulo - Editar',
    'delete_title'    => 'Módulo - Eliminar',
    'edit_all_title'  => 'Módulo - Editar Todo',
    'id'              => 'N°',
    'name'            => 'Nombre',
    'permission_key'  => 'Identificador de Permiso',    

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Nombre (editable)',
        'editable_status' => 'Estado (editable)',
    ],

    // Export
    'export_filename' => 'exportación_módulos',
    'export_title'    => 'Reporte de Módulos',

    // Validation messages
    // name
    'name_required' => 'El campo nombre es obligatorio.',
    'name_unique'   => 'Este módulo ya existe.',

    // iso_code
    'permission_key_required' => 'El campo permiso es obligatorio.',
    'permission_key_unique'   => 'Este permiso ya existe.',

    // deletion
    'deleted_description_required' => 'El motivo de eliminación es obligatorio.',
    'deleted_description_min'      => 'El motivo de eliminación debe tener al menos 3 caracteres.',
    'deleted_description_max'      => 'El motivo de eliminación no puede superar los 1000 caracteres.',
];