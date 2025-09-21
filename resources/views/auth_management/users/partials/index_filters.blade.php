<form action="{{ route('auth_management.users.index') }}" method="GET" class="mb-3">
  <div class="row">
    <div class="col-md-4">
      <label for="name" class="form-label">Nombre</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Ej. Axl"
             value="{{ request('name') }}">
    </div>

    <div class="col-md-4">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control" placeholder="Ej. axl@dominio.com"
             value="{{ request('email') }}">
    </div>

    <div class="col-md-4">
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
      <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-search"></i> Buscar
      </button>
      <a href="{{ route('auth_management.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-brush"></i> Limpiar
      </a>
    </div>
  </div>
</form>
