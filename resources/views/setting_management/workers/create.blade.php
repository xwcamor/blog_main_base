@extends('layouts.app')

@section('title', __('workers.create_title'))
@section('title_navbar', __('workers.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <h3 class="card-title"><strong><i class="fas fa-plus"></i> {{ __('global.create') }}</strong></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <form id="form-save" action="{{ route('setting_management.workers.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
          @csrf          
          <div class="form-group">
            <label for="num_doc">{{ __('workers.num_doc') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="num_doc" id="num_doc" class="form-control" data-parsley-minlength="8" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('workers.num_doc')]) }}">
          </div>

          <div class="form-group">
            <label for="name">{{ __('workers.name') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('workers.name')]) }}">
          </div>

          <div class="form-group">
            <label for="lastname">{{ __('workers.lastname') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="lastname" id="lastname" class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('workers.lastname')]) }}">
          </div>
        </form>
      </div>
      
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.workers.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection
@push('scripts')
    @include('setting_management.workers.partials.scripts')
@endpush
