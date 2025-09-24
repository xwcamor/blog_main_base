@extends('layouts.app')

@section('title', 'API Tester')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">API Tester</h3>
                </div>
                <div class="card-body">
                    <!-- Token Input -->
                    <div class="form-group">
                        <label for="api_token">API Token</label>
                        <input type="text" class="form-control" id="api_token" placeholder="sk-or-v1-...">
                    </div>

                    <!-- Current Locale (hidden) -->
                    <input type="hidden" id="current_locale" value="{{ App::getLocale() }}">

                    <!-- API URL Input -->
                    <div class="form-group">
                        <label for="api_url">API URL</label>
                        <input type="text" class="form-control" id="api_url" placeholder="/api/languages" value="/api/languages">
                    </div>

                    <!-- JSON Body Input -->
                    <div class="form-group">
                        <label for="json_body">JSON Body (for POST/PUT/PATCH)</label>
                        <textarea class="form-control" id="json_body" rows="4" placeholder='{"name": "Test Language", "iso_code": "tl"}'></textarea>
                    </div>

                    <!-- Quick Actions -->
                    <div class="form-group">
                        <label>Quick Actions</label>
                        <div class="btn-group-vertical d-block">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary btn-block" onclick="quickList()">List Languages</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-outline-success btn-block" onclick="quickCreate()">Create Language</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-warning btn-block" onclick="quickUpdate()">Update Language</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-outline-danger btn-block" onclick="quickDelete()">Delete Language</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HTTP Methods -->
                    <div class="form-group">
                        <label>HTTP Methods</label>
                        <div class="btn-group-vertical d-block">
                            <div class="row">
                                <div class="col-md-2">
                                    <button class="btn btn-info btn-block mb-2" onclick="sendRequest('GET')">GET</button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success btn-block mb-2" onclick="sendRequest('POST')">POST</button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-warning btn-block mb-2" onclick="sendRequest('PUT')">PUT</button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary btn-block mb-2" onclick="sendRequest('PATCH')">PATCH</button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger btn-block mb-2" onclick="sendRequest('DELETE')">DELETE</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Response -->
                    <div class="form-group">
                        <label>Response</label>
                        <pre id="response" class="bg-light p-3" style="min-height: 300px; border: 1px solid #ddd;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('api_tester.partials.scripts')