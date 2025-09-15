<form action="{{ route('setting_management.countries.index') }}" method="GET" class="mb-3">
  <div class="row">
    <div class="col-md-6">
      <label for="name" class="form-label">{{ __('countries.name') }}</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('countries.name')]) }}"
             value="{{ request('name') }}">
    </div>

    <div class="col-md-6">
      <label for="is_active" class="form-label">{{ __('countries.is_active') }}</label>
      <select name="is_active" id="is_active" class="form-control">
        <option value="">{{ __('global.all') }}</option>
        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
      </select>
    </div>
  </div>

  <div class="row pt-4">
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-primary mr-2">
        <i class="fas fa-search"></i> {{ __('global.search') }}
      </button>
      <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary">
        <i class="fas fa-brush"></i> {{ __('global.clear') }}
      </a>
    </div>
  </div>
</form>
