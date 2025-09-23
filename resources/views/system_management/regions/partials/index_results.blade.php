<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.regions.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('regions.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.regions.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('regions.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.regions.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('regions.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($regions as $region)
      <tr>
        <td>{{ $loop->iteration + $regions->firstItem() - 1 }}</td>
        <td>{{ $region->name }}</td>
        <td>{!! $region->state_html !!}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('system_management.regions.show', $region) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.regions.edit', $region) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.regions.delete', $region) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $regions->links() }}
</div>
