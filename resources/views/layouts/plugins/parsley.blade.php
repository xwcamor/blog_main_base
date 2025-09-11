<script src="{{ asset('adminlte/plugins/parsley/js/parsley.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/parsley/js/i18n/es.js') }}"></script>

<script>
  // Solo inicializa Parsley si existe el formulario con ID `form-save`
  if (document.getElementById('form-save')) {
    Parsley.setLocale('es');
    //Parsley.defaults.errorsWrapper = '<span class="parsley-errors-list"></span>';
    //Parsley.defaults.errorTemplate = '<span class="parsley-error text-danger"></span>';

    const form = $('#form-save');
    form.parsley(); // inicializa Parsley en ese form

    window.submitWithParsley = function () {
      if (form.parsley().validate()) {
        form.submit();
      }
    }
  }
</script>
