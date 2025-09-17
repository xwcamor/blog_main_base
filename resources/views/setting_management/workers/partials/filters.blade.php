<form action="{{ route('setting_management.workers.index') }}" method="GET" class="mb-3">
  <div class="row">
    <div class="col-md-4">
      <label for="num_doc" class="form-label">{{ __('workers.num_doc') }}</label>
      <input type="text" name="num_doc" id="num_doc" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('workers.num_doc')]) }}"
             value="{{ request('num_doc') }}">
    </div>

    <div class="col-md-4">
      <label for="name" class="form-label">{{ __('workers.name') }}</label>
      <input type="text" name="name" id="name" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('workers.name')]) }}"
             value="{{ request('name') }}">
    </div>

    <div class="col-md-4">
      <label for="lastname" class="form-label">{{ __('workers.lastname') }}</label>
      <input type="text" name="lastname" id="lastname" class="form-control" 
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('workers.lastname')]) }}"
             value="{{ request('lastname') }}">
    </div>
  </div>

  <div class="row pt-4">
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-search"></i> {{ __('global.search') }}
      </button>
      <a href="{{ route('setting_management.workers.index') }}" class="btn btn-secondary">
        <i class="fas fa-brush"></i> {{ __('global.clear') }}
      </a>
    </div>
  </div>
</form>
