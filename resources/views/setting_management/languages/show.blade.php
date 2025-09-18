@extends('layouts.app')

@section('title', __('languages.show_title'))
@section('title_navbar', __('languages.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-database"></i> {{ __('global.show') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">{{ __('languages.name') }}</span></label>
          <input type="text" id="name" class="form-control" value="{{ $language->name }}" disabled>
        </div>

        <div class="form-group">
          <label for="is_active">{{ __('languages.is_active') }}</span></label>
          <input type="text" id="is_active" class="form-control" value="{!! $language->state_text !!}" disabled>
        </div>

      </div>
      <div class="card-footer text-center">
        <a href="{{ route('setting_management.languages.index') }}" class="btn btn-secondary" title="{{ __('global.back') }}">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-info-circle"></i> {{ __('global.record_audit') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <p>
          <strong><i class="fas fa-user"></i> {{ __('global.created_by') }}:</strong>
          {{ $language->creator->name ?? '-' }}
        </p>
        <p>
          <strong><i class="fas fa-calendar-plus"></i> {{ __('global.created_at') }}:</strong>
          {{ $language->created_at->format('Y-m-d H:i') }}
        </p>

        @if ($language->trashed())
          <hr>
          <p>
            <strong><i class="fas fa-user-slash"></i> {{ __('global.deleted_by') }}:</strong>
            {{ $language->deleter->name ?? '-' }}
          </p>
          <p>
            <strong><i class="fas fa-calendar-times"></i> {{ __('global.deleted_at') }}:</strong>
            {{ $language->deleted_at->format('Y-m-d H:i') ?? '-' }}
          </p>
          <p>
            <strong><i class="fas fa-comment-alt"></i> {{ __('global.deleted_reason') }}:</strong>
            {{ $language->deleted_description ?? '-' }}
          </p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection