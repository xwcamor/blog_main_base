<form id="form-save" action="{{ route('system_management.system_modules.index') }}" method="GET">
  <div class="row">
    <div class="col-md-6">
      <label for="name" class="form-label">{{ __('system_modules.name') }}</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('system_modules.name')]) }}"
             value="{{ request('name') }}">
    </div>

    <div class="col-md-6">
      <label for="permission_key" class="form-label">{{ __('system_modules.permission_key') }}</label>
      <input type="text" name="permission_key" id="permission_key" class="form-control" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('system_modules.permission_key')]) }}"
             value="{{ request('permission_key') }}">      
    </div>
  </div>
</form>