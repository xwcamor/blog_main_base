@extends('layouts.app')

@section('title', __('countries.index_title'))
@section('title_navbar', __('countries.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-light rounded">
      <div class="card-header">
        <h3 class="card-title"><strong><i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}</strong></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        @include('setting_management.countries.partials.filters')
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-light rounded">
      <div class="card-header">
        <h3 class="card-title">
          <strong>
          <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
          @if ($countries->total() > 0)
            {{ $countries->total() }}
          @else
            0
          @endif
          </strong>
        </h3>
        <div class="card-tools">
            <a class="btn btn-tool btn-primary btn-sm" href="{{ route('setting_management.countries.create') }}">
              <i class="fas fa-plus"></i>  {{ __('global.create') }}
            </a>          
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
            </button>
        </div>
      </div>
      
      <div class="card-body">
        <div class="table-responsive">
          @include('setting_management.countries.partials.table')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 