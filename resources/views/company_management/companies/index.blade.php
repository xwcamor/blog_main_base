@extends('layouts.app')
@section('title', __('companies.index_title'))
@section('title_navbar', __('companies.plural'))
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
                @include('company_management.companies.partials.index_filters')
            </div>
            <div class="card-footer text-center">
                <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-2">
                    <i class="fas fa-search"></i> {{ __('global.search') }}
                </button>
                <a href="{{ route('company_management.companies.index') }}" class="btn btn-default">
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
                    <i class="fas fa-table"></i> {{ __('global.card_title_result') }}: {{ $companies->total() ?? 0 }}
                </h3>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('company_management.companies.create') }}">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
                    </a>
                    <a class="btn btn-sm bg-olive mr-2" href="{{ route('company_management.companies.edit_all') }}">
                        <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">{{ __('global.edit_all') }}</span>
                    </a>
                    {{-- Export Dropdown --}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline">{{ __('global.export') }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item text-dark" href="{{ route('company_management.companies.export_excel', request()->query()) }}">
                                <i class="fas fa-file-excel text-success"></i> {{ __('global.excel') }}
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('company_management.companies.export_pdf', request()->query()) }}">
                                <i class="fas fa-file-pdf text-danger"></i> {{ __('global.pdf') }}
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('company_management.companies.export_word', request()->query()) }}">
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
                    @include('company_management.companies.partials.index_results')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
