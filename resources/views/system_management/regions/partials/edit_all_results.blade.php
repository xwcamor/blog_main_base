<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.regions.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('regions.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.regions.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('regions.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.regions.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('regions.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($regions as $region)
      <tr>
        <td>{{ $region->id }}</td>

        <!-- Editable name field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $region->id }}"
            data-field="name"
            data-original="{{ $region->name }}">
          {{ $region->name }}
        </td>

        <!-- Editable status field -->
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $region->id }}"
                  data-field="is_active"
                  data-original="{{ $region->is_active }}">
            <option value="1" {{ $region->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
            <option value="0" {{ !$region->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
          </select>
        </td>

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
