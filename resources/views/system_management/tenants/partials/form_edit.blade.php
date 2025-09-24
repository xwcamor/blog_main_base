<form id="form-save" action="{{ route('system_management.tenants.update', $tenant) }}" method="POST" data-parsley-validate>
  @csrf
  @method('PUT')

  <div class="form-group">
    <label for="name">{{ __('tenants.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}"
           class="form-control" required data-parsley-minlength="3"
           placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('tenants.name')]) }}">
  </div>

  <div class="form-group">
    <label for="logo">{{ __('tenants.logo') }}</label>
    <input type="text" name="logo" id="logo" value="{{ old('logo', $tenant->logo) }}"
           class="form-control" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('tenants.logo')]) }}">
  </div>

  <div class="form-group">
    <label for="is_active">{{ __('tenants.is_active') }} <span class="text-danger">(*)</span></label>
    <select name="is_active" id="is_active" class="form-control" required>
      <option value="1" {{ old('is_active', $tenant->is_active) == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
      <option value="0" {{ old('is_active', $tenant->is_active) == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
    </select>
  </div>
</form>
