<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.tenants.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('tenants.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.tenants.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('tenants.name') }}
        </a>
      </th>
      <th>{{ __('tenants.logo') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.tenants.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('tenants.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($tenants as $tenant)
      <tr>
        <td>{{ $loop->iteration + $tenants->firstItem() - 1 }}</td>
        <td>{{ $tenant->name }}</td>
        <td>
          @if($tenant->logo)
            <img src="{{ $tenant->logo }}" alt="{{ $tenant->name }}" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
          @else
            <span class="text-muted">{{ __('global.no_image') }}</span>
          @endif
        </td>
        <td>{!! $tenant->state_html !!}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('system_management.tenants.show', $tenant) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.tenants.edit', $tenant) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.tenants.delete', $tenant) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $tenants->links() }}
</div>
