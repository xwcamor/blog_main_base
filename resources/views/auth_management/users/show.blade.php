@extends('layouts.app')

@section('title', 'Usuario - Información')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <i class="fas fa-database"></i> Datos del Registro
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">Nombre</label>
          <input type="text" id="name" class="form-control" value="{{ $user->name }}" disabled>
        </div>   

        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" id="email" class="form-control" value="{{ $user->email }}" disabled>
        </div>        

        <div class="form-group">
          <label for="photo">Foto</label><br>
          @if($user->photo)
            <img src="{{ asset('storage/photos/' . $user->photo) }}"
                class="img-circle elevation-2"
                width="100"  height="100">
          @else
            <img src="{{ asset('adminlte/img/user2-160x160.jpg') }}"
                class="img-circle elevation-2"
                width="100" height="100">
          @endif
        </div>  

        <div class="form-group">
          <label for="is_active">Estado</label>
          <input type="text" id="is_active" class="form-control" value="{{ $user->state_text }}" disabled>
        </div>          
  
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('auth_management.users.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Regresar
        </a>
      </div>
    </div>
  </div>
</div>
@endsection