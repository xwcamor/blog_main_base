@extends('layouts.app')
@section('title', __('companies.create_title'))
@section('title_navbar', __('companies.singular'))
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <h3 class="card-title"><strong><i class="fas fa-plus"></i> {{ __('global.create') }}</strong></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
       <form id="form-save" action="{{ route('setting_management.companies.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
            @csrf          
            <div class="form-group">
                <label for="ruc">{{ __('companies.ruc') }} <span class="text-danger">(*)</span></label>
                <input type="text" name="ruc" id="ruc" class="form-control" data-parsley-minlength="11" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.ruc')]) }}">
            </div>
            <div class="form-group">
                <label for="name">{{ __('companies.name') }} <span class="text-danger">(*)</span></label>
                <input type="text" name="name" id="name" class="form-control" readonly placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('companies.name')]) }}">
            </div>
        </form>
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.companies.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
    @include('setting_management.companies.partials.scripts')
@endpush

