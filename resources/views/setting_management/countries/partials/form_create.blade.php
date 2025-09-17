<form id="form-save" action="{{ route('setting_management.countries.store') }}" method="POST" data-parsley-validate>
  @csrf          
          
  <div class="form-group">
    <label for="name">{{ __('countries.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('countries.name')]) }}">
  </div>
</form>