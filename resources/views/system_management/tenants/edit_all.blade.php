@extends('layouts.app')

@section('title', __('tenants.edit_all_title'))
@section('title_navbar', __('tenants.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('system_management.tenants.partials.index_filters')
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> {{ __('global.search') }}
        </button>
        <a href="{{ route('system_management.tenants.edit_all') }}" class="btn btn-default">
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
          @if ($tenants->total() > 0)
            {{ $tenants->total() }}
          @else
            0
          @endif
        </h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-primary mr-2" href="{{ route('system_management.tenants.create') }}">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
          </a>
          <a class="btn btn-sm bg-olive mr-2" href="{{ route('system_management.tenants.index') }}">
            <i class="fas fa-list"></i> <span class="d-none d-sm-inline">{{ __('global.view_list') }}</span>
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          @include('system_management.tenants.partials.edit_all_results')
        </div>
      </div>
    </div>
  </div>
</div>

@include('system_management.tenants.partials.edit_all_scripts')
@endsection
