$(function () {
    // Setup AJAX to send CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const updateUrl = $('#countries-table').data('update-url');

    // Function to handle the update
    function updateField(id, field, value, element) {
        $.ajax({
            url: updateUrl,
            method: "POST",
            data: {
                id: id,
                field: field,
                value: value
            },
            success: function (response) {
                // Temporary green background on success
                element.closest('td').css("background-color", "#d4edda");
                setTimeout(() => element.closest('td').css("background-color", ""), 1200);
            },
            error: function (xhr) {
                // Temporary red background on error
                element.closest('td').css("background-color", "#f8d7da");
                setTimeout(() => element.closest('td').css("background-color", ""), 1200);
                console.error("Error saving:", xhr.responseText);
            }
        });
    }

    // Update for contenteditable fields
    $(document).on("blur", ".editable", function() {
        let cell = $(this);
        let id = cell.data("id");
        let field = cell.data("field");
        let value = cell.text().trim();
        
        // Do not save if the value is empty for 'name'
        if (field === 'name' && value === "") {
            // Optionally, you can revert to the original value or show an error
            // For now, we just prevent saving.
            return; 
        }

        updateField(id, field, value, cell);
    });

    // Update for select fields
    $(document).on("change", ".editable-select", function() {
        let select = $(this);
        let id = select.data("id");
        let field = select.data("field");
        let value = select.val();

        updateField(id, field, value, select);
    });
});
