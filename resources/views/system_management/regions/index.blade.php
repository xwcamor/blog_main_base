@extends('layouts.app')

@section('title', __('regions.index_title'))
@section('title_navbar', __('regions.plural'))

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
        @include('system_management.regions.partials.index_filters')
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> {{ __('global.search') }}
        </button>
        <a href="{{ route('system_management.regions.index') }}" class="btn btn-default">
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
          @if ($regions->total() > 0)
            {{ $regions->total() }}
          @else
            0
          @endif
        </h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-primary mr-2" href="{{ route('system_management.regions.create') }}">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
          </a>
          <a class="btn btn-sm bg-olive mr-2" href="{{ route('system_management.regions.edit_all') }}">
            <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">{{ __('global.edit_all') }}</span>
          </a>
          <!-- Export Dropdown -->
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline">{{ __('global.export') }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-dark" href="{{ route('system_management.regions.export_excel', request()->query()) }}">
                <i class="fas fa-file-excel text-success"></i> {{ __('global.excel') }}
              </a>
              <a class="dropdown-item text-dark" href="{{ route('system_management.regions.export_pdf', request()->query()) }}">
                <i class="fas fa-file-pdf text-danger"></i> {{ __('global.pdf') }}
              </a>
              <a class="dropdown-item text-dark" href="{{ route('system_management.regions.export_word', request()->query()) }}">
                <i class="fas fa-file-word text-primary"></i> {{ __('global.word') }}
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
          @include('system_management.regions.partials.index_results')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
