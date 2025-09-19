<form id="form-save" action="{{ route('system_management.languages.update', $language) }}" method="POST" data-parsley-validate>
  @csrf
  @method('PUT')

  <div class="form-group">
    <label for="name">{{ __('languages.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $language->name) }}"
           class="form-control" required data-parsley-minlength="3"
           placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('languages.name')]) }}">
  </div>

  <div class="form-group">
    <label for="iso_code">{{ __('languages.iso_code') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="iso_code" id="iso_code" value="{{ old('iso_code', $language->iso_code) }}"
           class="form-control" required data-parsley-minlength="2" maxlength="10" placeholder="ISO 639-1: es, en, pt, de">
  </div>

  <div class="form-group">
    <label for="is_active">{{ __('languages.is_active') }} <span class="text-danger">(*)</span></label>
    <select name="is_active" id="is_active" class="form-control" required>
      <option value="1" {{ old('is_active', $language->is_active) == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
      <option value="0" {{ old('is_active', $language->is_active) == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
    </select>
  </div>
</form>