<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('company_management.companies.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          ID
          @if(request('sort') === 'id')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
          @endif
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('company_management.companies.index', array_merge(request()->all(), ['sort' => 'ruc', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('companies.ruc') }}
          @if(request('sort') === 'ruc')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
          @endif
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('company_management.companies.index', array_merge(request()->all(), ['sort' => 'razon_social', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('companies.razon_social') }}
          @if(request('sort') === 'razon_social')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
          @endif
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('company_management.companies.index', array_merge(request()->all(), ['sort' => 'direccion', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('companies.direccion') }}
          @if(request('sort') === 'direccion')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
          @endif
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('company_management.companies.index', array_merge(request()->all(), ['sort' => 'num_doc', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('companies.num_doc') }}
          @if(request('sort') === 'num_doc')
            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
          @endif
        </a>
      </th>
      <th>{{ __('companies.created_at') }}</th>
      <th width="120">{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($companies as $company)
      <tr>
        <td>{{ $company->id }}</td>
        <td>{{ $company->ruc }}</td>
        <td>{{ $company->razon_social }}</td>
        <td>{{ $company->direccion }}</td>
        <td>{{ $company->num_doc }}</td>
        <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('company_management.companies.show', $company) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('company_management.companies.edit', $company) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('company_management.companies.delete', $company) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center">{{ __('global.no_records') }}</td>
      </tr>
    @endforelse
  </tbody>
</table>

@if($companies->hasPages())
  <div class="d-flex justify-content-center">
    {{ $companies->appends(request()->query())->links() }}
  </div>
@endif
