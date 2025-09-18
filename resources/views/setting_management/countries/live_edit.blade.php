@extends('layouts.app')

@section('title', __('countries.live_edit_title'))
@section('title_navbar', __('countries.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('setting_management.countries.partials.index_filters')
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> {{ __('global.search') }}
        </button>        
        <a href="{{ route('setting_management.countries.live_edit') }}" class="btn btn-default">
          <i class="fas fa-brush"></i> {{ __('global.clear') }}
        </a>
      </div>    
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title pt-1">
          <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
          @if ($countries->total() > 0)
            {{ $countries->total() }}
          @else
            0
          @endif
        </h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-secondary mr-2" href="{{ route('setting_management.countries.index') }}">
            <i class="fas fa-arrow-left"></i> <span class="d-none d-sm-inline">{{ __('global.back') }}</span>
          </a>
          <a class="btn btn-sm btn-primary mr-2" href="{{ route('setting_management.countries.create') }}">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>      
      <div class="card-body">
        <div class="table-responsive">
          <table id="countries-table" class="table table-bordered bg-white" data-update-url="{{ route('setting_management.countries.update_inline') }}">
            <thead class="bg-light">
              <tr>
                <th>{{ __('global.id') }}</th>
                <th>{{ __('global.name') }} ({{ __('global.editable') }})</th>
                <th>{{ __('global.status') }} ({{ __('global.editable') }})</th>
              </tr>
            </thead>
            <tbody>
              @foreach($countries as $country)
                <tr>
                  <td>{{ $country->id }}</td>
                  <td class="editable" contenteditable="true" data-id="{{ $country->id }}" data-field="name">
                    {{ $country->name }}
                  </td>
                  <td>
                    <select class="editable-select form-control" data-id="{{ $country->id }}" data-field="is_active">
                      <option value="1" {{ $country->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
                      <option value="0" {{ !$country->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
                    </select>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('adminlte/js/custom_live_edit.js') }}"></script>
@endsection
