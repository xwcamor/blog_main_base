@extends('layouts.app')

@section('title', 'Pais - Nuevo')

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
        <form id="form-save" action="{{ route('setting_management.countries.store') }}" method="POST" data-parsley-validate>
          @csrf          
          <div class="form-group">
            <label for="name">Nombre <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" class="form-control" data-parsley-minlength="3" required placeholder="Digite Nombre">
          </div>
        </form>
      </div>
      
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary mr-2">
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