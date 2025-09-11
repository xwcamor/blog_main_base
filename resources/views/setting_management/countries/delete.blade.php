@extends('layouts.app')

@section('title', 'País - Eliminar')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-trash-alt"></i> Eliminar Registro
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      
      <div class="card-body">
        <form id="form-save" action="{{ route('setting_management.countries.deleteSave', $country) }}" method="POST" data-parsley-validate>
          @csrf
          @method('DELETE')
          <div class="alert alert-danger">
            <strong>Advertencia:</strong> Esta acción marcará el registro como eliminado.
          </div>

          <div class="form-group">
            <label for="name">Nombre del país</label>
            <input type="text" id="name" class="form-control" value="{{ $country->name }}" disabled>
          </div>

          <div class="form-group">
            <label for="deleted_description">Motivo de eliminación <span class="text-danger">*</span></label>
            <textarea name="deleted_description" id="deleted_description" rows="4" class="form-control" data-parsley-minlength="3" required>{{ old('deleted_description') }}</textarea>

            @error('deleted_description')
              <small class="text-danger">{{ $message }}</small>
            @enderror
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