<div class="form-group">
  <label for="name">{{ __('languages.name') }}</span></label>
  <input type="text" id="name" class="form-control" value="{{ $language->name }}" disabled>
</div>

<div class="form-group">
  <label for="iso_code">{{ __('languages.iso_code') }}</span></label>
  <input type="text" id="iso_code" class="form-control" value="{{ $language->iso_code }}" disabled>
</div>

<div class="form-group">
  <label for="is_active">{{ __('languages.is_active') }}</span></label>
  <input type="text" id="is_active" class="form-control" value="{!! $language->state_text !!}" disabled>
</div>