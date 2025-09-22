@extends('layouts.app')

@section('title', __('global.my_downloads'))
@section('title_navbar', __('global.my_downloads'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-download"></i> {{ __('global.my_downloads') }}
                </h3>
                <div class="card-tools">
                    <button type="button" id="refresh-downloads" class="btn btn-sm btn-primary">
                        <i class="fas fa-sync-alt"></i> {{ __('global.refresh') }}
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="auto-refresh-indicator" class="alert alert-info d-none">
                    <i class="fas fa-spinner fa-spin"></i> {{ __('global.waiting_for_download') }}
                </div>
                <div id="downloads-container">
                    @include('download_management.user_downloads.partials.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('download_management.user_downloads.partials.scripts')
@endpush