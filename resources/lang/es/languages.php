<?php

return [
    'singular'        => 'Idioma',
    'plural'          => 'Idiomas',

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
    'is_active'       => 'Estado',

    // Table headers for live edit
    'table_headers' => [
        'editable_name' => 'Nombre (editable)',
        'editable_status' => 'Estado (editable)',
    ],

    // Status options
    'status_options' => [
        'active' => 'Activo',
        'inactive' => 'Inactivo',
    ],

    // Actions
    'actions' => [
        'back' => 'Regresar',
    ],

    // Export
    'export_filename' => 'exportacion_idiomas',
    'pdf_title' => 'Listado de Idiomas',
    'pdf_subtitle' => 'Generado el',

    // Validation messages
    'name_required' => 'El campo nombre es obligatorio.',
    'name_unique' => 'Este nombre de idioma ya existe.',
    'is_active_required' => 'El campo estado es obligatorio.',
    'deleted_description_required' => 'El motivo de eliminación es obligatorio.',
    'deleted_description_min' => 'El motivo de eliminación debe tener al menos 3 caracteres.',
    'deleted_description_max' => 'El motivo de eliminación no puede exceder los 1000 caracteres.',
];