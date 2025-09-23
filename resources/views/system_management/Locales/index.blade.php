@extends('layouts.app')

@section('title', __('locales.plural'))
@section('title_navbar', __('locales.plural'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{-- Filtros --}}
        <div class="card card-info rounded mb-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
                <form id="filters-form" method="GET" action="{{ route('system_management.locales.index') }}">
                    <div class="form-row">
                        <div class="col-md-4 mb-2">
                            <input type="text" name="name" class="form-control"
                                placeholder="{{ __('locales.name') }}"
                                value="{{ request('name') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
              <button type="submit" form="filters-form" class="btn btn-primary mr-4">
                <i class="fas fa-search"></i> {{ __('global.search') }}
              </button>
              <a href="{{ route('system_management.locales.index') }}" class="btn btn-default">
                <i class="fas fa-brush"></i> {{ __('global.clear') }}
              </a>
            </div>
        </div>

        {{-- Resultados --}}
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> {{ __('locales.plural') }}
                </h3>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('system_management.locales.create') }}">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('locales.name') }}</th>
                            <!-- N+1 FIX VIEW SIDE: mostramos el nombre del idioma desde la relación eager-loaded 'language' -->
                            <th>{{ __('languages.singular') }}</th>
                            <th>{{ __('locales.code') }}</th>
                            <th>{{ __('global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locales as $locale)
                            <tr>
                                <td>{{ $locale->id }}</td>
                                <td>{{ $locale->name }}</td>
                                <!-- Safe access con optional() por si algún registro no tiene language asociado -->
                                <td>{{ optional($locale->language)->name }}</td>
                                <td>{{ $locale->code }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-light" href="{{ route('system_management.locales.edit', $locale) }}" title="{{ __('global.edit') }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-light" href="{{ route('system_management.locales.delete', $locale) }}" title="{{ __('global.delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('locales.no_results') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $locales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
