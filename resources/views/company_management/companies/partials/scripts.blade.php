<script>
  document.addEventListener('DOMContentLoaded', function () {
    const rucInput = document.getElementById('ruc');

    rucInput.addEventListener('keyup', function () {
      const ruc = rucInput.value.trim();

      // Referencias a los inputs
      const razonSocialInput = document.getElementById('razon_social');
      const direccionInput   = document.getElementById('direccion');
      const numDocInput      = document.getElementById('num_doc');

      if (ruc.length === 11) {
        fetch(`/company_management/companies/fetch-ruc/${ruc}`)
          .then(response => response.json())
          .then(data => {
            razonSocialInput.value = data.razon_social ?? '';
            direccionInput.value   = data.direccion ?? '';
            numDocInput.value      = data.num_doc ?? '';
          })
          .catch(error => {
            console.error('Error fetching RUC data:', error);
            // Opcional: limpiar campos si falla la consulta
            razonSocialInput.value = '';
            direccionInput.value   = '';
            numDocInput.value      = '';
          });
      } else {
        // Limpiar campos si RUC no tiene 11 dígitos válidos
        razonSocialInput.value = '';
        direccionInput.value   = '';
        numDocInput.value      = '';
      }
    });
  });
</script>


