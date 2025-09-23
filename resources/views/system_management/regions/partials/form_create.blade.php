<form id="form-save" action="{{ route('system_management.regions.store') }}" method="POST" data-parsley-validate>
  @csrf

  <div class="form-group">
    <label for="name">{{ __('regions.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" class="form-control" required data-parsley-minlength="3" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('regions.name')]) }}">
  </div>
</form>
