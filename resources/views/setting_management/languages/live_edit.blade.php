@extends('layouts.app')

@section('title', __('languages.live_edit_title'))
@section('title_navbar', __('languages.singular'))

@section('content')
<div class="container mt-4">
    <table class="table table-bordered bg-white">
        <thead class="bg-light">
            <tr>
                <th>{{ __('languages.id') }}</th>
                <th>{{ __('languages.table_headers.editable_name') }}</th>
                <th>{{ __('languages.table_headers.editable_status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($languages as $language)
                <tr>
                    <td>{{ $language->id }}</td>

                    <!-- Editable name -->
                    <td class="editable"
                        contenteditable="true"
                        data-id="{{ $language->id }}"
                        data-field="name">
                        {{ $language->name }}
                    </td>

                    <!-- Editable status -->
                    <td>
                        <select class="editable-select" data-id="{{ $language->id }}" data-field="is_active">
                            <option value="1" {{ $language->is_active ? 'selected' : '' }}>{{ __('languages.status_options.active') }}</option>
                            <option value="0" {{ !$language->is_active ? 'selected' : '' }}>{{ __('languages.status_options.inactive') }}</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Back button below table -->
    <div class="mt-3">
        <a href="{{ route('setting_management.languages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('languages.actions.back') }}
        </a>
    </div>
</div>
@endsection

@include('setting_management.languages.partials.scripts')