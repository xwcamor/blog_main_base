@extends('layouts.app')

@section('title', __('countries.create_title'))
@section('title_navbar', __('countries.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-light rounded">
      <div class="card-header">
        <h3 class="card-title"><strong><i class="fas fa-plus"></i> {{ __('global.create') }}</strong></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <form id="form-save" action="{{ route('setting_management.countries.store') }}" method="POST" data-parsley-validate>
          @csrf          
          <div class="form-group">
            <label for="name">{{ __('countries.name') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('countries.name')]) }}">
          </div>
        </form>
      </div>
      
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary mr-2">
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