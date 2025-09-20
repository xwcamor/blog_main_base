<script>
  document.addEventListener('DOMContentLoaded', function () {
    const rucInput = document.getElementById('ruc');

    rucInput.addEventListener('keyup', function () {
      const ruc = rucInput.value;

      if (ruc.length === 11) {
        fetch(`/system_management/companies/fetch-ruc/${ruc}`)
          .then(response => response.json())
          .then(data => {
            if (data.razon_social) {
              document.getElementById('razon_social').value = data.razon_social;
            }
            if (data.direccion) {
              document.getElementById('direccion').value = data.direccion;
            }
          })
          .catch(error => console.error('Error fetching RUC data:', error));
      }
    });
  });

</script>