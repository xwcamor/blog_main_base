@extends('layouts.app')

@section('title', __('system_modules.show_title'))
@section('title_navbar', __('system_modules.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-database"></i> {{ __('global.show') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('system_management.system_modules.partials.form_show')
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('system_management.system_modules.index') }}" class="btn btn-secondary" title="{{ __('global.back') }}">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-info-circle"></i> {{ __('global.record_audit') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('system_management.languages.partials.form_show_audit')
      </div>
    </div>
  </div>
</div>
@endsection