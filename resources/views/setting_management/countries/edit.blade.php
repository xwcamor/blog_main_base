@extends('layouts.app')

@section('title', 'Pais - Editar')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-pen"></i> Editar Registro
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
 
      <div class="card-body">
        <form id="form-save" action="{{ route('setting_management.countries.update', $country) }}" method="POST" data-parsley-validate>
          @csrf
          @method('PUT')   
          <div class="form-group">
            <label for="name">Nombre <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $country->name) }}" 
                   class="form-control" data-parsley-minlength="3" required placeholder="Digite Nombre">
          </div>
 
          <div class="form-group">
            <label for="is_active">Estado <span class="text-danger">(*)</span></label>
            <select name="is_active" id="is_active" class="form-control" required>
              <option value="1" {{ old('is_active', $country->is_active) == '1' ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ old('is_active', $country->is_active) == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>

        </form>  
      </div>

      <div class="card-footer text-center">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> Regresar
        </a>
        <button type="submit" onclick="submitWithParsley()" class="btn btn-primary">
          <i class="fas fa-save"></i> Actualizar Datos
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection
