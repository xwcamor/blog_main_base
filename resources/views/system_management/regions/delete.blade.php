@extends('layouts.app')

@section('title', __('regions.delete_title'))
@section('title_navbar', __('regions.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> {{ __('global.delete') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('system_management.regions.partials.form_delete')
      </div>
      <div class="card-footer text-center">
        <button type="submit" onclick="confirmDelete()" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> {{ __('global.destroy') }}
        </button>
        <a href="{{ route('system_management.regions.index') }}" class="btn btn-default" title="{{ __('global.back') }}">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
