<script>
document.addEventListener('DOMContentLoaded', function () {
    const dniInput = document.getElementById('num_doc');
    const nameInput = document.getElementById('name');
    const lastnameInput = document.getElementById('lastname');

    dniInput.addEventListener('blur', function () {
        let dni = dniInput.value.trim();

        if (dni.length === 8) {
            fetch(`/api/sunat/${dni}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        nameInput.value = data.nombres;
                        lastnameInput.value = data.apellidoPaterno + ' ' + data.apellidoMaterno;
                    } else {
                        alert('DNI no encontrado en RENIEC');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});

$('#num_doc').on('blur', function() {
    let num_doc = $(this).val();
    if (num_doc.length > 0) {
        $.get("{{ route('setting_management.workers.fetch_dni') }}", { num_doc: num_doc }, function(data) {
            $('#name').val(data.name || '');
            $('#lastname').val(data.lastname || '');
        });
    }
});
</script>
