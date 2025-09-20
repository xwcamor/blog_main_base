<script>
document.addEventListener('DOMContentLoaded', function () {
    const rucInput = document.getElementById('ruc');
    const nameInput = document.getElementById('name');

    rucInput.addEventListener('blur', function () {
        let ruc = rucInput.value.trim();

        if (ruc.length === 11) { // RUC siempre tiene 11 dígitos
            fetch("{{ route('setting_management.companies.fetchRuc') }}?ruc=" + ruc)
                .then(response => response.json())
                .then(data => {
                    nameInput.value = data.name || ''; // Solo llenar razón social
                })
                .catch(() => {
                    nameInput.value = ''; // Limpiar si hay error
                });
        } else {
            nameInput.value = '';
        }
    });
});
</script>
