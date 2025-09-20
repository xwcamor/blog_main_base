@extends('layouts.app')
@section('title', __('companies.delete_title'))
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-trash-alt"></i> {{ __('global.delete_record') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <form id="form-save" action="{{ route('setting_management.companies.deleteSave', $company) }}" method="POST" data-parsley-validate>
        @csrf
        @method('DELETE')
        <div class="card-body">
          <div class="alert alert-danger">
            <strong>{{ __('global.warning') }}:</strong> {{ __('global.warning_delete') }}
          </div>
          <div class="form-group">
            <label for="ruc">{{ __('companies.ruc') }}</label>
            <input type="text" id="ruc" class="form-control" value="{{ $company->ruc }}" disabled>
          </div>
          <div class="form-group">
            <label for="name">{{ __('companies.name') }}</label>
            <input type="text" id="name" class="form-control" value="{{ $company->name }}" disabled>
          </div>
          <div class="form-group">
            <label for="deleted_description">{{ __('global.deleted_reason') }} <span class="text-danger">*</span></label>
            <textarea name="deleted_description" id="deleted_description" rows="4" class="form-control" data-parsley-minlength="3" required>{{ old('deleted_description') }}</textarea>
            @error('deleted_description')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="card-footer text-center">
          <a href="{{ route('setting_management.companies.index') }}" class="btn btn-secondary mr-2">
              <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
          </a>
          <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> {{ __('global.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
