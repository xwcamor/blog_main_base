@extends('layouts.app')

@section('title', __('companies.delete_title'))
@section('title_navbar', __('companies.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> {{ __('global.delete') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle"></i> {{ __('global.warning') }}: {{ __('global.warning_delete') }}
        </div>

        <form id="form-save" action="{{ route('company_management.companies.deleteSave', $company) }}" method="POST" data-parsley-validate>
          @csrf
          @method('DELETE')

          <div class="form-group">
            <label for="num_doc">{{ __('companies.num_doc') }}</label>
            <input type="text" id="num_doc" class="form-control" value="{{ $company->num_doc }}" disabled>
          </div>

          <div class="form-group">
            <label for="name">{{ __('companies.name') }}</label>
            <input type="text" id="name" class="form-control" value="{{ $company->name }}" disabled>
          </div>

          <div class="form-group">
            <label for="deleted_description">{{ __('global.delete_description') }} <span class="text-danger">(*)</span></label>
            <textarea name="deleted_description" id="deleted_description" rows="4" class="form-control" data-parsley-minlength="3" required>{{ old('deleted_description') }}</textarea>
            @error('deleted_description')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </form>
      </div>

      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> {{ __('global.destroy') }}
        </button>
        <a href="{{ route('company_management.companies.index') }}" class="btn btn-default" title="{{ __('global.back') }}">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
