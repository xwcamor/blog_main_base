@extends('layouts.app')

@section('title', __('workers.index_title'))

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
          @include('setting_management.workers.partials.filters')
        </div>
      </div>
    </div>
  </div>    

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
            <i class="fas fa-table"></i> {{ __('global.card_title_result') }}: 
            @if ($workers->total() > 0)<strong>{{ $workers->total() }}</strong>@else 0 @endif
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>    
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-right pt-0 pb-1">
              <a class="btn btn-primary" href="{{ route('setting_management.workers.create') }}">
                <i class="fas fa-plus"></i> {{ __('global.create') }}
              </a>
            </div>
          </div>
          <div class="table-responsive">
            @include('setting_management.workers.partials.table')
          </div>
        </div>
      </div>
    </div>
  </div>    
@endsection
