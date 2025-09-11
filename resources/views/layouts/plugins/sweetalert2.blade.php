
@if (session('success'))     
  {{-- <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Éxito!',
      text: '{{ session('success') }}',
      showConfirmButton: false,       // Hide
      timer: 1500,                    // 1.5 seg
      timerProgressBar: true          // Display a progress bar
    });
  </script>

@endif


@if (session('error'))     
  {{-- <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
  <script>
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: '{{ session('error') }}',
      showConfirmButton: false,       // Hide
      timer: 9500,                    // 1.5 seg
      timerProgressBar: true          // Display a progress bar
    });
  </script>

@endif

{{-- Display error validations --}}        
@if ($errors->any())
  {{-- <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.js') }}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: '{{ $errors->first() }}',
      showConfirmButton: false,       // Hide
      timer: 5000,                    // 1.5 seg
      timerProgressBar: true          // Display a progress bar
    });
  </script>
@endif