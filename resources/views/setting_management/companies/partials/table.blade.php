<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.companies.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          ID
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.companies.index', array_merge(request()->all(), ['sort' => 'ruc', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('companies.ruc') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('setting_management.companies.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('companies.name') }}
        </a>
      </th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($companies as $company)
      <tr>
        <td>{{ $company->id }}</td>
        <td>{{ $company->ruc }}</td>
        <td>{{ $company->name }}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('setting_management.companies.show', $company) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('setting_management.companies.edit', $company) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('setting_management.companies.delete', $company) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="d-flex justify-content-center mt-3">
  {{ $companies->links() }}
</div>
