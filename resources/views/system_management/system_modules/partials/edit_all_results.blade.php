<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.languages.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('languages.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.languages.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('languages.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('system_management.languages.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('languages.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($languages as $language)
      <tr>
        <td>{{ $language->id }}</td>

        <!-- Editable name field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $language->id }}"
            data-field="name"
            data-original="{{ $language->name }}">
          {{ $language->name }}
        </td>

        <!-- Editable status field -->
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $language->id }}"
                  data-field="is_active"
                  data-original="{{ $language->is_active }}">
            <option value="1" {{ $language->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
            <option value="0" {{ !$language->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
          </select>
        </td>

        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('system_management.languages.show', $language) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.languages.edit', $language) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('system_management.languages.delete', $language) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $languages->links() }}
</div>