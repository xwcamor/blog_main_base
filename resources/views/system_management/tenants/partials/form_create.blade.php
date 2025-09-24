<form id="form-save" action="{{ route('system_management.tenants.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
  @csrf

  <div class="form-group">
    <label for="name">{{ __('tenants.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" class="form-control" required data-parsley-minlength="3" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('tenants.name')]) }}">
  </div>

  <div class="form-group">
    <label for="logo">{{ __('tenants.logo') }}</label>
    <input type="file" name="logo" class="form-control">
  </div>
      
</form>