@extends('layouts.app')
@section('title', __('companies.create_title'))
@section('title_navbar', __('companies.singular'))
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-body">
        <form id="form-save" action="{{ route('company_management.companies.store') }}" method="POST">
          @csrf
          <label>{{ __('companies.num_doc') }}</label>
          <input type="text" id="num_doc" name="num_doc" class="form-control" value="{{ old('num_doc') }}" required>

          <label>{{ __('companies.name') }}</label>
          <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary">{{ __('global.save') }}</button>
        <a href="{{ route('company_management.companies.index') }}" class="btn btn-default">{{ __('global.cancel') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    @include('company_management.companies.partials.create_all_scripts')
@endpush
