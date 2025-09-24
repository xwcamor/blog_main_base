<form id="form-save" action="{{ route('system_management.languages.store') }}" method="POST" data-parsley-validate>
  @csrf

  <div class="form-group">
    <label for="name">{{ __('languages.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" class="form-control" required data-parsley-minlength="3" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('languages.name')]) }}">
  </div>

  <div class="form-group">
    <label for="iso_code">{{ __('languages.iso_code') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="iso_code" id="iso_code" class="form-control" required data-parsley-minlength="2" maxlength="10" placeholder="es, en, pt, de">
  </div>
</form>