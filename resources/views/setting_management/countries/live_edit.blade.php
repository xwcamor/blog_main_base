@extends('layouts.app')

@section('title', __('countries.live_edit_title'))
@section('title_navbar', __('countries.singular'))

@section('content')
<div class="container mt-4">
    <table class="table table-bordered bg-white">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Nombre (editable)</th>
                <th>Estado (editable)</th> <!-- Nueva columna -->
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>

                    <!-- Nombre editable -->
                    <td class="editable"
                        contenteditable="true"
                        data-id="{{ $country->id }}"
                        data-field="name">
                        {{ $country->name }}
                    </td>

                    <!-- Estado editable -->
                    <td>
                        <select class="editable-select" data-id="{{ $country->id }}" data-field="is_active">
                            <option value="1" {{ $country->is_active ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$country->is_active ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Botón regresar debajo de la tabla -->
    <div class="mt-3">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary">
             Regresar
        </a>
    </div>
</div>

<style>
    /* Fondo blanco y sombra suave para la tabla */
    table.bg-white {
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    // Actualizar campos contenteditable
    $(document).on("blur", ".editable", function() {
        let cell = $(this);
        let id = cell.data("id");
        let field = cell.data("field");
        let value = cell.text().trim();
        if(value === "") return;

        updateField(id, field, value, cell);
    });

    // Actualizar campos select
    $(document).on("change", ".editable-select", function() {
        let select = $(this);
        let id = select.data("id");
        let field = select.data("field");
        let value = select.val();

        updateField(id, field, value, select);
    });

    // Función común para AJAX
    function updateField(id, field, value, element) {
        $.ajax({
            url: "{{ route('setting_management.countries.update_inline') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                field: field,
                value: value
            },
            success: function (response) {
                // Fondo verde temporal al guardar
                element.css("background-color", "#d4edda");
                setTimeout(() => element.css("background-color", ""), 800);
            },
            error: function (xhr) {
                // Fondo rojo temporal si hay error
                element.css("background-color", "#f8d7da");
                setTimeout(() => element.css("background-color", ""), 800);
                console.error("Error al guardar:", xhr.responseText);
            }
        });
    }
</script>
@endsection