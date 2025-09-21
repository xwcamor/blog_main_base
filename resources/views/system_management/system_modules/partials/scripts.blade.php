<script>
function updatePermissionKey() {
    let nameInput = document.getElementById('name');
    let permInput = document.getElementById('permission_key');

    let value = nameInput.value.trim();

    // Capitalizar la primera letra, dejar lo demás libre (ej. UserCountry)
    if (value.length > 0) {
        nameInput.value = value.charAt(0).toUpperCase() + value.slice(1);
    }

    // Convertir a snake_case
    let snake = value
        .replace(/([a-z])([A-Z])/g, '$1_$2') // UserCountry -> user_Country
        .replace(/\s+/g, '_')                // espacios -> _
        .toLowerCase();

    // Pluralización simple
    if (snake.endsWith('y')) {
        permInput.value = snake.slice(0, -1) + 'ies';
    } else if (snake.endsWith('s')) {
        permInput.value = snake + 'es';
    } else if (snake.length > 0) {
        permInput.value = snake + 's';
    } else {
        permInput.value = '';
    }
}
</script>