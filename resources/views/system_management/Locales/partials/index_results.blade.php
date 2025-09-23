<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.locales.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('locales.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.locales.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('locales.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.locales.index', array_merge(request()->all(), ['sort' => 'code', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('locales.code') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.locales.index', array_merge(request()->all(), ['sort' => 'language_id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('locales.language') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.locales.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('locales.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($locales as $locale)
      <tr>
        <td>{{ $loop->iteration + $locales->firstItem() - 1 }}</td>
        <td>{{ $locale->name }}</td>
        <td>{{ $locale->code }}</td>
        <td>{{ $locale->language->name ?? '-' }}</td>
        <td>{!! $locale->state_html !!}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('system_management.locales.show', $locale) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.locales.edit', $locale) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.locales.delete', $locale) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $locales->links() }}
</div>
