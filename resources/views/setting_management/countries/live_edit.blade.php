@extends('layouts.app')

@section('title', __('countries.live_edit_title'))
@section('title_navbar', __('countries.singular'))

@section('content')
<div class="container mt-4">
    <table id="countries-table" class="table table-bordered bg-white" data-update-url="{{ route('setting_management.countries.update_inline') }}">
        <thead class="bg-light">
            <tr>
                <th>{{ __('global.id') }}</th>
                <th>{{ __('global.name') }} ({{ __('global.editable') }})</th>
                <th>{{ __('global.status') }} ({{ __('global.editable') }})</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td class="editable" contenteditable="true" data-id="{{ $country->id }}" data-field="name">
                        {{ $country->name }}
                    </td>
                    <td>
                        <select class="editable-select form-control" data-id="{{ $country->id }}" data-field="is_active">
                            <option value="1" {{ $country->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
                            <option value="0" {{ !$country->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('setting_management.countries.index') }}" class="btn btn-secondary">
             {{ __('global.back') }}
        </a>
    </div>
</div>
@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('adminlte/js/custom_live_edit.js') }}"></script>
@endsection