<div class="form-group">
    <label for="name">{{ __('companies.name') }}</label>
    <input type="text" id="name" class="form-control" value="{{ $company->name }}" disabled>
</div>

<div class="form-group">
    <label for="ruc">{{ __('companies.ruc') }}</label>
    <input type="text" id="ruc" class="form-control" value="{{ $company->ruc }}" disabled>
</div>

<div class="form-group">
    <label for="is_active">{{ __('companies.is_active') }}</label>
    <input type="text" id="is_active" class="form-control" value="{!! $company->state_text !!}" disabled>
</div>
