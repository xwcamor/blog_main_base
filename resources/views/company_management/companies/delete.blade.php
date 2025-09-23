@extends('layouts.app')

@section('title', __('companies.delete_title'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-trash"></i> {{ __('companies.delete_title') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="alert alert-warning">
          <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('global.warning') }}</h5>
          {{ __('global.delete_confirmation') }}
        </div>

        <div class="row">
          <div class="col-md-4">
            <strong>{{ __('companies.ruc') }}:</strong> {{ $company->ruc }}
          </div>
          <div class="col-md-4">
            <strong>{{ __('companies.razon_social') }}:</strong> {{ $company->razon_social }}
          </div>
          <div class="col-md-4">
            <strong>{{ __('companies.num_doc') }}:</strong> {{ $company->num_doc ?? '-' }}
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <strong>{{ __('companies.direccion') }}:</strong> {{ $company->direccion }}
          </div>
        </div>
      </div>

      <div class="card-footer text-center">
        <form id="form-save" action="{{ route('company_management.companies.deleteSave', $company) }}" method="POST" data-parsley-validate>
          @csrf
          @method('DELETE')

          <a href="{{ route('company_management.companies.index') }}" class="btn btn-secondary mr-2">
            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
          </a>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> {{ __('global.delete') }}
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
