<script>
document.addEventListener('DOMContentLoaded', function () {
    const dniInput = document.getElementById('num_doc');
    const nameInput = document.getElementById('name');

    dniInput.addEventListener('blur', function () {
        let dni = dniInput.value.trim();

        if (dni.length === 8) {
            // Usamos la ruta nombrada con LaravelLocalization
            let url = "{{ url(app()->getLocale() . '/company_management/companies/fetch-dni') }}/" + dni;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.name) {
                        nameInput.value = data.name;
                    } else if (data.error) {
                        nameInput.value = '';
                        alert(data.error);
                    } else {
                        nameInput.value = '';
                        alert('DNI no encontrado.');
                    }
                })
                .catch(error => {
                    console.error('Error al consultar DNI:', error);
                    nameInput.value = '';
                });
        } else {
            nameInput.value = '';
        }
    });
});
</script>
