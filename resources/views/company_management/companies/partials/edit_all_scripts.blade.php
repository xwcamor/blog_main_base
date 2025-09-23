@push('scripts')
<script>
$(document).ready(function() {
    // Editar celda de texto (name, ruc, etc.)
    $(document).on('blur', '.editable-cell', function() {
        const cell = $(this);
        const id = cell.data('id');
        const field = cell.data('field');
        const newValue = cell.text().trim();
        const originalValue = cell.data('original');

        if (newValue !== originalValue && newValue !== '') {
            saveField(id, field, newValue, cell);
        }
    });

    // Editar select (ejemplo: is_active)
    $(document).on('change', '.editable-select', function() {
        const select = $(this);
        const id = select.data('id');
        const field = select.data('field');
        const newValue = select.val();
        const originalValue = select.data('original');

        if (newValue !== originalValue.toString()) {
            saveField(id, field, newValue, select);
        }
    });

    // Función de guardado vía AJAX
    function saveField(id, field, value, element) {
        element.css('opacity', '0.6');
        $.ajax({
            url: "{{ route('company_management.companies.update_inline') }}",
            method: 'POST',
            data: { _token: "{{ csrf_token() }}", id: id, field: field, value: value },
            success: function(response) {
                if (response.success) {
                    element.css({'background-color':'#d4edda','opacity':'1'});
                    element.data('original', value);
                    setTimeout(() => element.css('background-color',''), 2000);
                }
            },
            error: function(xhr) {
                element.css({'background-color':'#f8d7da','opacity':'1'});
                setTimeout(() => element.css('background-color',''), 2000);
                console.error('Save error:', xhr.responseText);
            }
        });
    }

    // Enter key guarda la celda
    $(document).on('keydown', '.editable-cell', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            $(this).blur();
        }
    });
});
</script>

<style>
.editable-cell {
    cursor: pointer;
    min-height: 30px;
    padding: 8px;
    border: 1px solid transparent;
    transition: all 0.2s ease;
}
.editable-cell:hover { border-color: #dee2e6; background-color: #f8f9fa; }
.editable-cell:focus { outline: none; border-color: #007bff; background-color: #fff; box-shadow: 0 0 0 2px rgba(0,123,255,.25); }

.editable-select {
    border: 1px solid transparent;
    transition: all 0.2s ease;
}
.editable-select:focus { border-color: #007bff; box-shadow: 0 0 0 2px rgba(0,123,255,.25); }
</style>
@endpush
