<form id="form-save" action="{{ route('system_management.regions.update', $region) }}" method="POST" data-parsley-validate>
  @csrf
  @method('PUT')

  <div class="form-group">
    <label for="name">{{ __('regions.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $region->name) }}"
           class="form-control" required data-parsley-minlength="3"
           placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('regions.name')]) }}">
  </div>

  <div class="form-group">
    <label for="is_active">{{ __('regions.is_active') }} <span class="text-danger">(*)</span></label>
    <select name="is_active" id="is_active" class="form-control" required>
      <option value="1" {{ old('is_active', $region->is_active) == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
      <option value="0" {{ old('is_active', $region->is_active) == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
    </select>
  </div>
</form>
