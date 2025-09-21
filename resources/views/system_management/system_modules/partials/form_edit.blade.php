<form id="form-save" action="{{ route('system_management.system_modules.update', $system_module) }}" method="POST" data-parsley-validate>
  @csrf
  @method('PUT')

  <div class="form-group">
    <label for="name">{{ __('system_modules.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $system_module->name) }}"
           class="form-control" required data-parsley-minlength="3"
           placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('system_modules.name')]) }}">
  </div>

  <div class="form-group">
    <label for="permission_key">{{ __('system_modules.permission_key') }} <span class="text-danger">(*)</span></label>
    <input type="text" id="permission_key" class="form-control"
                   value="{{ $system_module->permission_key }}" readonly>
  </div>  
   
</form>