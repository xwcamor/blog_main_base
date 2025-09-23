<form id="form-save" action="{{ route('system_management.locales.index') }}" method="GET">
  <div class="row">
    <div class="col-md-4">
      <label for="name" class="form-label">{{ __('locales.name') }}</label>
      <input type="text" name="name" id="name" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('locales.name')]) }}"
             value="{{ request('name') }}">
    </div>

    <div class="col-md-4">
      <label for="code" class="form-label">{{ __('locales.code') }}</label>
      <input type="text" name="code" id="code" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('locales.code')]) }}"
             value="{{ request('code') }}">
    </div>

    <div class="col-md-4">
      <label for="is_active" class="form-label">{{ __('locales.is_active') }}</label>
      <select name="is_active" id="is_active" class="form-control">
        <option value="">{{ __('global.all') }}</option>
        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
      </select>
    </div>
  </div>
</form>
