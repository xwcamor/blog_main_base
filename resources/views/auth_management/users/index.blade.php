@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
          <i class="fas fa-filter"></i> Filtro de Búsqueda
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>    
        <div class="card-body">
          @include('auth_management.users.partials.index_filters')
        </div>
      </div>
    </div>
  </div>    

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
            <i class="fas fa-table"></i> Resultados: 
            @if ($users->total() > 0)<strong>{{ $users->total() }}</strong>@else 0 @endif
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>    
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-right pt-0 pb-1">
              <a class="btn btn-primary" href="{{ route('auth_management.users.create') }}">
                <i class="fas fa-plus"></i> Crear Registro
              </a>
            </div>
          </div>
          <div class="table-responsive">
            @include('auth_management.users.partials.index_results')
          </div>
        </div>
      </div>
    </div>
  </div>    
@endsection
