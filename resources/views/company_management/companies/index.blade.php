@extends('layouts.app')

@section('title', __('companies.index_title'))

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
          <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @include('company_management.companies.partials.filters')
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
            <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
            @if ($companies->total() > 0)<strong>{{ $companies->total() }}</strong>@else 0 @endif
          <div class="card-tools">
            <!-- Export Dropdown -->
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline">{{ __('global.export') }}</span>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <form method="POST" action="{{ route('company_management.companies.exportExcel') }}" style="display: inline;">
                  @csrf
                  @foreach(request()->query() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                  @endforeach
                  <button type="submit" class="dropdown-item text-dark">
                    <i class="fas fa-file-excel text-success"></i> {{ __('global.excel') }}
                  </button>
                </form>
                <form method="POST" action="{{ route('company_management.companies.exportPdf') }}" style="display: inline;">
                  @csrf
                  @foreach(request()->query() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                  @endforeach
                  <button type="submit" class="dropdown-item text-dark">
                    <i class="fas fa-file-pdf text-danger"></i> {{ __('global.pdf') }}
                  </button>
                </form>
                <form method="POST" action="{{ route('company_management.companies.exportWord') }}" style="display: inline;">
                  @csrf
                  @foreach(request()->query() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                  @endforeach
                  <button type="submit" class="dropdown-item text-dark">
                    <i class="fas fa-file-word text-primary"></i> {{ __('global.word') }}
                  </button>
                </form>
              </div>
            </div>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-right pt-0 pb-1">
              <a class="btn btn-primary" href="{{ route('company_management.companies.create') }}">
                <i class="fas fa-plus"></i> {{ __('global.create') }}
              </a>
            </div>
          </div>
          <div class="table-responsive">
            @include('company_management.companies.partials.table')
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection