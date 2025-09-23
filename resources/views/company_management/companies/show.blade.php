@extends('layouts.app')
@section('title', __('companies.show_title'))
@section('title_navbar', __('companies.singular'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-database"></i> {{ __('global.show') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>{{ __('companies.num_doc') }}:</label>
                    <input type="text" class="form-control" value="{{ $company->num_doc }}" disabled>
                </div>
                <div class="form-group">
                    <label>{{ __('companies.name') }}:</label>
                    <input type="text" class="form-control" value="{{ $company->name }}" disabled>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('company_management.companies.index') }}" class="btn btn-secondary" title="{{ __('global.back') }}">
                    <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
