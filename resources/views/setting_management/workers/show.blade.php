@extends('layouts.app')

@section('title', __('workers.show_title'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <i class="fas fa-database"></i> {{ __('global.record_data') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="num_doc">{{ __('workers.num_doc') }}</label>
          <input type="text" id="num_doc" class="form-control" value="{{ $worker->num_doc }}" disabled>
        </div>   

        <div class="form-group">
          <label for="name">{{ __('workers.name') }}</label>
          <input type="text" id="name" class="form-control" value="{{ $worker->name }}" disabled>
        </div>        

        <div class="form-group">
          <label for="lastname">{{ __('workers.lastname') }}</label>
          <input type="text" id="lastname" class="form-control" value="{{ $worker->lastname }}" disabled>
        </div>  
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.workers.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
