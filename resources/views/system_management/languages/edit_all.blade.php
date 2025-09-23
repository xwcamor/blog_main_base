@extends('layouts.app')

@section('title', __('languages.edit_all_title'))
@section('title_navbar', __('languages.plural'))

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
        @include('system_management.languages.partials.index_filters')
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> {{ __('global.search') }}
        </button>
        <a href="{{ route('system_management.languages.edit_all') }}" class="btn btn-default">
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
          @if ($languages->total() > 0)
            {{ $languages->total() }}
          @else
            0
          @endif
        </h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-primary mr-2" href="{{ route('system_management.languages.create') }}">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
          </a>
          <a class="btn btn-sm bg-olive mr-2" href="{{ route('system_management.languages.index') }}">
            <i class="fas fa-list"></i> <span class="d-none d-sm-inline">{{ __('global.view_list') }}</span>
          </a>
          <!-- Export Dropdown -->
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline">{{ __('global.export') }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-dark" href="{{ route('system_management.languages.export_excel', request()->query()) }}">
                <i class="fas fa-file-excel text-success"></i> {{ __('global.excel') }}
              </a>
              <a class="dropdown-item text-dark" href="{{ route('system_management.languages.export_pdf', request()->query()) }}">
                <i class="fas fa-file-pdf text-danger"></i> {{ __('global.pdf') }}
              </a>
            </div>
          </div>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          @include('system_management.languages.partials.edit_all_results')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@include('layouts.plugins.parsley')
@endpush

@include('system_management.languages.partials.edit_all_scripts')
