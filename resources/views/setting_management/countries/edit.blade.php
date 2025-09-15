@extends('layouts.app')

@section('title', __('countries.edit_title'))
@section('title_navbar', __('countries.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-pen"></i> {{ __('global.edit') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
 
      <div class="card-body">
        <form id="form-save" action="{{ route('setting_management.countries.update', $country) }}" method="POST" data-parsley-validate>
          @csrf
          @method('PUT')   
          <div class="form-group">
            <label for="name">{{ __('countries.name') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $country->name) }}" 
                   class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('countries.name')]) }}">
          </div>
 
          <div class="form-group">
            <label for="is_active">{{ __('countries.is_active') }} <span class="text-danger">(*)</span></label>
            <select name="is_active" id="is_active" class="form-control" required>
              <option value="1" {{ old('is_active', $country->is_active) == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
              <option value="0" {{ old('is_active', $country->is_active) == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
            </select>
          </div>

        </form>  
      </div>

      <div class="card-footer text-center">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
        <button type="submit" onclick="submitWithParsley()" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ __('global.update') }}
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection
