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
                   
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="downloads-container">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 
@endpush