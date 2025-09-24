<div class="form-group">
  <label for="name">{{ __('tenants.name') }}</label>
  <input type="text" id="name" class="form-control" value="{{ $tenant->name }}" disabled>
</div>

<div class="form-group">
  <label for="logo">{{ __('tenants.logo') }}</label>
  @if($tenant->logo)
    <div class="mt-2">
      <img src="{{ $tenant->logo }}" alt="{{ $tenant->name }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
    </div>
  @else
    <input type="text" id="logo" class="form-control" value="{{ __('global.no_image') }}" disabled>
  @endif
</div>

<div class="form-group">
  <label for="is_active">{{ __('tenants.is_active') }}</label>
  <input type="text" id="is_active" class="form-control" value="{!! $tenant->state_text !!}" disabled>
</div>
