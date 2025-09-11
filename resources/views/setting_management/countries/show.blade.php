@extends('layouts.app')

@section('title', 'Pais - Información')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-database"></i> Datos del Registro
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">Nombre</span></label>
          <input type="text" id="name" class="form-control" value="{{ $country->name }}" disabled>
        </div>        
 
        <div class="form-group">
          <label for="is_active">Estado</span></label>
          <input type="text" id="is_active" class="form-control" value="{!! $country->state_text !!}" disabled>
        </div>   
 
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Regresar
        </a>
      </div>
    </div>
  </div>
</div>
@endsection