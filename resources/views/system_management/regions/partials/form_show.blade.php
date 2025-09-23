<div class="form-group">
  <label for="name">{{ __('regions.name') }}</label>
  <input type="text" id="name" class="form-control" value="{{ $region->name }}" disabled>
</div>

<div class="form-group">
  <label for="is_active">{{ __('regions.is_active') }}</label>
  <input type="text" id="is_active" class="form-control" value="{!! $region->state_text !!}" disabled>
</div>
