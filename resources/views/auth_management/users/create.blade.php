@extends('layouts.app')

@section('title', 'Usuario - Nuevo')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-plus"></i> Crear Registro
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <form id="form-save" action="{{ route('auth_management.users.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
          @csrf          
          <div class="form-group">
            <label for="name">Nombre <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Digite Nombre">
          </div>

          <div class="form-group">
              <label for="email">Email <span class="text-danger">(*)</span></label>
              <input type="email" name="email" id="email" class="form-control" required placeholder="Digite Correo Electrónico">
          </div>

          <div class="form-group">
            <label for="password">Contraseña <span class="text-danger">(*)</span></label>
            <input type="password" name="password" id="password" class="form-control" required placeholder="Digite Contraseña" >
          </div>

          <div class="form-group">
              <label for="photo">Foto</label>
              <input type="file" name="photo" class="form-control">
          </div>          
        </form>
      </div>
      
      <div class="card-footer text-center">
        <a href="{{ route('auth_management.users.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> Regresar
        </a>
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary">
          <i class="fas fa-save"></i> Guardar Datos
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection