@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    // Update contenteditable fields
    $(document).on("blur", ".editable", function() {
        let cell = $(this);
        let id = cell.data("id");
        let field = cell.data("field");
        let value = cell.text().trim();
        if(value === "") return;

        updateField(id, field, value, cell);
    });

    // Update select fields
    $(document).on("change", ".editable-select", function() {
        let select = $(this);
        let id = select.data("id");
        let field = select.data("field");
        let value = select.val();

        updateField(id, field, value, select);
    });

    // Common AJAX function
    function updateField(id, field, value, element) {
        $.ajax({
            url: "{{ route('setting_management.languages.update_inline') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                field: field,
                value: value
            },
            success: function (response) {
                // Temporary green background on save
                element.css("background-color", "#d4edda");
                setTimeout(() => element.css("background-color", ""), 800);
            },
            error: function (xhr) {
                // Temporary red background on error
                element.css("background-color", "#f8d7da");
                setTimeout(() => element.css("background-color", ""), 800);
                console.error("Save error:", xhr.responseText);
            }
        });
    }
</script>

<style>
    /* White background and soft shadow for table */
    table.bg-white {
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>
@endpush