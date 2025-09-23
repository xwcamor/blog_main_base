@extends('layouts.app')

@section('title', __('global.edit'))
@section('title_navbar', __('locales.plural'))

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
                @include('system_management.locales.partials.form_edit')
            </div>
            <div class="card-footer text-center">
                <button type="submit" form="form-save" class="btn btn-primary mr-4">
                    <i class="fas fa-save"></i> {{ __('global.update') }}
                </button>
                <a href="{{ route('system_management.locales.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> {{ __('global.cancel') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
