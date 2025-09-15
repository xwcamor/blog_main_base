@extends('layouts.app')

@section('title', __('countries.show_title'))
@section('title_navbar', __('countries.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-database"></i> {{ __('global.show') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">{{ __('countries.name') }}</span></label>
          <input type="text" id="name" class="form-control" value="{{ $country->name }}" disabled>
        </div>        
 
        <div class="form-group">
          <label for="is_active">{{ __('countries.is_active') }}</span></label>
          <input type="text" id="is_active" class="form-control" value="{!! $country->state_text !!}" disabled>
        </div>   
 
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary" title="{{ __('global.back') }}">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection