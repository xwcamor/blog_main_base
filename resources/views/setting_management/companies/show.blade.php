@extends('layouts.app')
@section('title', __('companies.show_title'))
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <i class="fas fa-database"></i> {{ __('global.record_data') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="ruc">{{ __('companies.ruc') }}</label>
          <input type="text" id="ruc" class="form-control" value="{{ $company->ruc }}" disabled>
        </div>   

        <div class="form-group">
          <label for="name">{{ __('companies.name') }}</label>
          <input type="text" id="name" class="form-control" value="{{ $company->name }}" disabled>
        </div>         
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.companies.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
