<form id="form-save" action="{{ route('system_management.system_modules.store') }}" method="POST" data-parsley-validate>
  @csrf

  <div class="form-group">
    <label for="name">{{ __('system_modules.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" 
          name="name" 
          id="name" 
          class="form-control" 
          required 
          oninput="updatePermissionKey()">
  </div>

  <div class="form-group">
    <label for="permission_key">{{ __('system_modules.permission_key') }} <span class="text-danger">(*)</span></label>
    <input type="text" 
          name="permission_key" 
          id="permission_key" 
          class="form-control" 
          readonly>
  </div>

</form>

