<form action="{{ route('setting_management.companies.index') }}" method="GET" class="mb-3">
  <div class="row">
    <div class="col-md-6">
      <label for="ruc" class="form-label">{{ __('companies.ruc') }}</label>
      <input type="text" name="ruc" id="ruc" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.ruc')]) }}"
             value="{{ request('ruc') }}">
    </div>
    <div class="col-md-6">
      <label for="name" class="form-label">{{ __('companies.name') }}</label>
      <input type="text" name="name" id="name" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.name')]) }}"
             value="{{ request('name') }}">
    </div>
  </div>
  <div class="row pt-4">
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-search"></i> {{ __('global.search') }}
      </button>
      <a href="{{ route('setting_management.companies.index') }}" class="btn btn-secondary">
        <i class="fas fa-brush"></i> {{ __('global.clear') }}
      </a>
    </div>
  </div>
</form>
