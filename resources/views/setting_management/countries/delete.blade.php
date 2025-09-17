@extends('layouts.app')

@section('title', __('countries.delete_title'))
@section('title_navbar', __('countries.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash-alt"></i> {{ __('global.delete') }}
        </h3>  
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>      
      <div class="card-body">
        @include('setting_management.countries.partials.form_delete')
      </div>        
      <div class="card-footer text-center">
        <button type="button" class="btn btn-danger mr-4" onclick="confirmDelete()">
          <i class="fas fa-save"></i> {{ __('global.destroy') }}
        </button>
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-default" title="{{ __('global.back') }}">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>        
      </div>        
    </div>
  </div>
</div>
@endsection