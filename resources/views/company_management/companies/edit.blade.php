@extends('layouts.app')

@section('title', __('companies.edit_title'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-pen"></i> {{ __('companies.edit_title') }}
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <form id="form-save" action="{{ route('company_management.companies.update', $company) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
        @csrf
        @method('PUT')
        <div class="card-body">

          {{-- RUC --}}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="ruc">{{ __('companies.ruc') }} <span class="text-danger">*</span></label>
                <input type="text" name="ruc" id="ruc" class="form-control @error('ruc') is-invalid @enderror"
                       value="{{ old('ruc', $company->ruc) }}" placeholder="{{ __('companies.ruc') }}" maxlength="11" required>
                @error('ruc')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          {{-- Razón Social --}}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="razon_social">{{ __('companies.razon_social') }} <span class="text-danger">*</span></label>
                <input type="text" name="razon_social" id="razon_social" class="form-control @error('razon_social') is-invalid @enderror"
                       value="{{ old('razon_social', $company->razon_social) }}" placeholder="{{ __('companies.razon_social') }}" required>
                @error('razon_social')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          {{-- Dirección --}}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="direccion">{{ __('companies.direccion') }} <span class="text-danger">*</span></label>
                <textarea name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror"
                          rows="3" placeholder="{{ __('companies.direccion') }}" required>{{ old('direccion', $company->direccion) }}</textarea>
                @error('direccion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          {{-- Número de Documento --}}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="num_doc">{{ __('companies.num_doc') }}</label>
                <input type="text" name="num_doc" id="num_doc" class="form-control @error('num_doc') is-invalid @enderror"
                       value="{{ old('num_doc', $company->num_doc) }}" placeholder="{{ __('companies.num_doc') }}">
                @error('num_doc')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

        </div>

        <div class="card-footer text-center">
          <a href="{{ route('company_management.companies.index') }}" class="btn btn-secondary mr-2">
            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ __('global.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@section('scripts')
  @include('company_management.companies.partials.scripts')
@endsection
