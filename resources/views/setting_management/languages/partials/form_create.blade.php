<form id="form-save" action="{{ route('setting_management.languages.store') }}" method="POST" data-parsley-validate>
  @csrf

  <div class="form-group">
    <label for="name">{{ __('languages.name') }} <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('languages.name')]) }}">
  </div>

  <div class="form-group">
    <label for="locale">{{ __('languages.locale') }}</label>
    <input type="text" name="locale" id="locale" class="form-control" maxlength="10" placeholder="Ej: en, es_ES">
  </div>

  <div class="form-group">
    <label for="flag">{{ __('languages.flag') }}</label>
    <input type="text" name="flag" id="flag" class="form-control" maxlength="255" placeholder="Ej: us.png">
  </div>

  <div class="form-group">
    <label for="is_active">{{ __('languages.is_active') }} <span class="text-danger">(*)</span></label>
    <select name="is_active" id="is_active" class="form-control" required>
      <option value="1" selected>{{ __('global.active') }}</option>
      <option value="0">{{ __('global.inactive') }}</option>
    </select>
  </div>
</form>