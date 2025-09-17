@extends('layouts.app')

@section('title', __('workers.edit_title'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-pen"></i> {{ __('global.edit_record') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
 
      <div class="card-body">
        <form id="form-save" action="{{ route('setting_management.workers.update', $worker) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
          @csrf
          @method('PUT')   
          
          <div class="form-group">
            <label for="num_doc">{{ __('workers.num_doc') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="num_doc" id="num_doc" 
                   value="{{ old('num_doc', $worker->num_doc) }}" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label for="name">{{ __('workers.name') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $worker->name) }}" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label for="lastname">{{ __('workers.lastname') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="lastname" id="lastname" 
                   value="{{ old('lastname', $worker->lastname) }}" 
                   class="form-control" required>
          </div>

        </form>  
      </div>

      <div class="card-footer text-center">
        <a href="{{ route('setting_management.workers.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
        <button type="submit" onclick="document.getElementById('form-save').submit();" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ __('global.update') }}
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection
