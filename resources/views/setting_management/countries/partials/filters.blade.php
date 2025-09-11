<form action="{{ route('setting_management.countries.index') }}" method="GET" class="mb-3">
  <div class="row">
    <div class="col-md-6">
      <label for="name" class="form-label">Nombre</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Escribe Nombre"
             value="{{ request('name') }}">
    </div>

    <div class="col-md-6">
      <label for="is_active" class="form-label">Estado</label>
      <select name="is_active" id="is_active" class="form-control">
        <option value="">Todos</option>
        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>
  </div>

  <div class="row pt-4">
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-primary mr-2">
        <i class="fas fa-search"></i> Buscar
      </button>
      <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary">
        <i class="fas fa-brush"></i> Limpiar
      </a>
    </div>
  </div>
</form>
