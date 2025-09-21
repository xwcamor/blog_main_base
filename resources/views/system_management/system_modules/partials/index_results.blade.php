<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.system_modules.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('system_modules.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.system_modules.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('system_modules.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.system_modules.index', array_merge(request()->all(), ['sort' => 'permission_key', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('system_modules.permission_key') }}
        </a>
      </th>         
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($system_modules as $system_module)
      <tr>
        <td>{{ $loop->iteration + $system_modules->firstItem() - 1 }}</td>
        <td>{{ $system_module->name }}</td>
        <td>{{ $system_module->permission_key }}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('system_management.system_modules.show', $system_module) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.system_modules.edit', $system_module) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.system_modules.delete', $system_module) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $system_modules->links() }}
</div>