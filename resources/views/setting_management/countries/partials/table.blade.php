<table class="table  table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.countries.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('countries.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.countries.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('countries.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.countries.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('countries.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($countries as $country)
      <tr>
        <td>{{ $country->id }}</td>
        <td>{{ $country->name }}</td>
        <td>{!! $country->state_html !!}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('setting_management.countries.show', $country) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('setting_management.countries.edit', $country) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('setting_management.countries.delete', $country) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>                   
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $countries->links() }}
</div>
