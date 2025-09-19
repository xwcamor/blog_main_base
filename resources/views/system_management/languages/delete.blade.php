@extends('layouts.app')

@section('title', __('languages.delete_title'))
@section('title_navbar', __('languages.singular'))

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
        @include('system_management.languages.partials.form_delete')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> {{ __('global.destroy') }}
        </button>
        <a href="{{ route('system_management.languages.index') }}" class="btn btn-default" title="{{ __('global.back') }}">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection