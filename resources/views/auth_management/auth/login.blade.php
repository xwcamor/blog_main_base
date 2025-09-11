@extends('layouts.login')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
      </div>

      <div class="card-body">
        <form id="form-login" action="{{ route('login.post') }}" method="POST" data-parsley-validate>
          @csrf

          <div class="form-group">
            <label for="email">Correo electrónico <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" required data-parsley-type="email">
          </div>

          <div class="form-group">
            <label for="password">Contraseña <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="form-group d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-sign-in-alt"></i> Ingresar
            </button>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection