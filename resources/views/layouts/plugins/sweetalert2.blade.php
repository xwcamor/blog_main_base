{{-- Begin Script and style --}}
<link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

{{-- Start Script Alerts --}}
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: false,
      timerProgressBar: true          // Display a progress bar
    });
    
    // Session success   
    @if (session('success'))
      Toast.fire({
        icon: 'success',
        title: '{{ __('global.success') }}',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500
      });
    @endif
    
    // Session error   
    @if (session('error'))
      Toast.fire({
        icon: 'error',
        title: '{{ __('global.error') }}',
        text: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 2000
      });
    @endif

    // Display error validations       
    @if ($errors->any())
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ $errors->first() }}',
        showConfirmButton: false,      
        timer: 3000 
      });
    @endif
  });

  // Función para confirmación de eliminación
  function confirmDelete() {
    Swal.fire({
      title: "{{ __('global.are_you_sure') }}",
      text: "{{ __('global.warning_delete') }}",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: "{{ __('global.destroy') }}",
      cancelButtonText: "{{ __('global.cancel') }}"
    }).then((result) => {
      if (result.isConfirmed) {
        if ($('#form-save').parsley().validate()) {
          document.getElementById('form-save').submit();
        }
      }
    });
  }
</script>
