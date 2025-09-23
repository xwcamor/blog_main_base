@extends('layouts.app')
@section('title', __('companies.edit_title'))
@section('title_navbar', __('companies.singular'))

@section('content')
<div class="row">
    <div class="col-lg-12"> 
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> {{ __('global.edit') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="form-save" action="{{ route('company_management.companies.update', $company->slug) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label>{{ __('companies.num_doc') }}</label>
                    <input type="text" id="num_doc" name="num_doc" class="form-control" value="{{ old('num_doc', $company->num_doc) }}" required>

                    <label>{{ __('companies.name') }}</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                </form>
            </div>
            <div class="card-footer text-center">
                <button type="submit" form="form-save" class="btn btn-primary mr-2">
                    <i class="fas fa-save"></i> {{ __('global.update') }}
                </button>
                <a href="{{ route('company_management.companies.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> {{ __('global.cancel') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
