@extends('layouts.app')

@section('title', __('companies.show_title'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-eye"></i> {{ __('companies.show_title') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('companies.ruc') }}</label>
              <p class="form-control-plaintext">{{ $company->ruc }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('companies.razon_social') }}</label>
              <p class="form-control-plaintext">{{ $company->razon_social }}</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('companies.direccion') }}</label>
              <p class="form-control-plaintext">{{ $company->direccion }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('companies.num_doc') }}</label>
              <p class="form-control-plaintext">{{ $company->num_doc }}</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('companies.created_at') }}</label>
              <p class="form-control-plaintext">{{ $company->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('companies.updated_at') }}</label>
              <p class="form-control-plaintext">{{ $company->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer text-center">
        <a href="{{ route('company_management.companies.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
