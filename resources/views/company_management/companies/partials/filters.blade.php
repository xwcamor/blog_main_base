<form action="{{ route('company_management.companies.index') }}" method="GET" class="mb-3">
  <div class="row">
    {{-- RUC --}}
    <div class="col-md-3">
      <div class="form-group">
        <label for="ruc">{{ __('companies.ruc') }}</label>
        <input type="text" name="ruc" id="ruc" class="form-control" value="{{ request('ruc') }}" placeholder="{{ __('companies.ruc') }}">
      </div>
    </div>

    {{-- Razón Social --}}
    <div class="col-md-3">
      <div class="form-group">
        <label for="razon_social">{{ __('companies.razon_social') }}</label>
        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ request('razon_social') }}" placeholder="{{ __('companies.razon_social') }}">
      </div>
    </div>

    {{-- Dirección --}}
    <div class="col-md-3">
      <div class="form-group">
        <label for="direccion">{{ __('companies.direccion') }}</label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ request('direccion') }}" placeholder="{{ __('companies.direccion') }}">
      </div>
    </div>

    {{-- Número de Documento --}}
    <div class="col-md-3">
      <div class="form-group">
        <label for="num_doc">{{ __('companies.num_doc') }}</label>
        <input type="text" name="num_doc" id="num_doc" class="form-control" value="{{ request('num_doc') }}" placeholder="{{ __('companies.num_doc') }}">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="form-group d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-2">
          <i class="fas fa-search"></i> {{ __('global.search') }}
        </button>
        <a href="{{ route('company_management.companies.index') }}" class="btn btn-secondary">
          <i class="fas fa-brush"></i> {{ __('global.clear') }}
        </a>
      </div>
    </div>
  </div>
</form>
