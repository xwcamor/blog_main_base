<?php

return [
    // Titles
    'singular'        => 'Idioma',
    'plural'          => 'Idiomas',
    
    // Columns
    'index_title'     => 'Listado de Idiomas',
    'create_title'    => 'Idioma - Crear',
    'show_title'      => 'Idioma - Información',
    'edit_title'      => 'Idioma - Editar',
    'delete_title'    => 'Idioma - Eliminar',
    'live_edit_title' => 'Idioma - Editar todos',
    'edit_all_title'  => 'Idioma - Editar Todo',
    'edit_all'        => 'Editar Todo',
    'view_list'       => 'Ver Lista',
    'id'              => 'N°',
    'name'            => 'Nombre',
    'iso_code'        => 'ISO 639-1',    
    'is_active'       => 'Estado',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Nombre (editable)',
        'editable_status' => 'Estado (editable)',
    ],

    // Export
    'export_filename' => 'exportacion_idiomas',
    'export_title'    => 'Reporte de Idiomas',

    // Validation messages
    // name
    'name_required' => 'El campo nombre es obligatorio.',
    'name_unique'   => 'Este idioma ya existe.',

    // iso_code
    'iso_code_required' => 'El código ISO es obligatorio.',
    'iso_code_regex'    => 'El código ISO debe tener un formato válido (ej. es, en, pt_BR).',

    // is_active
    'is_active_required' => 'El campo estado es obligatorio.',

    // deletion
    'deleted_description_required' => 'El motivo de eliminación es obligatorio.',
    'deleted_description_min'      => 'El motivo de eliminación debe tener al menos 3 caracteres.',
    'deleted_description_max'      => 'El motivo de eliminación no puede superar los 1000 caracteres.',
];