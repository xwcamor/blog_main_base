
<div class="form-group">
  <label for="permission_key">{{ __('permissions.plural') }} <span class="text-danger">(*)</span></label>
</div>  

<ul class="list-group">
  @foreach($system_module->permissions as $perm)
  <li class="list-group-item d-flex justify-content-between align-items-center">
    {{ $perm->name }}
    @if(!in_array($perm->name, [
      $system_module->permission_key.'.view',
      $system_module->permission_key.'.create',
      $system_module->permission_key.'.edit',
      $system_module->permission_key.'.delete',
      $system_module->permission_key.'.export',
    ]))
      <!-- Botón eliminar -->
      <form method="POST" action="{{ route('system_management.system_modules.permissions.destroy', [$system_module, $perm->id]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> {{ __('global.remove') }}</button>
      </form>
    @else
      
    @endif
  </li>
  @endforeach
</ul>

<br>
<form method="POST" action="{{ route('system_management.system_modules.permissions.store', $system_module) }}" class="mt-3">
    @csrf
    <div class="input-group input-group-sm">
    <input type="text" name="action" class="form-control" placeholder="approve, import, lock..." required>
    <span class="input-group-append">
        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-plus"></i> {{ __('global.add') }}</button>
    </span>
    </div>
</form>