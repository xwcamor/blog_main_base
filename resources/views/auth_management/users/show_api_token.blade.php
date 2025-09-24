@extends('layouts.app')

@section('title', 'API Token Generated')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">API Token Generated</h3>
                </div>
                <div class="card-body">
                    <p>Your API token has been generated successfully. Copy it and keep it safe:</p>
                    <div class="input-group">
                        <input type="text" class="form-control" id="api_token" value="{{ $api_token }}" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">Copy</button>
                        </div>
                    </div>
                    <br>
                    <a href="{{ route('auth_management.users.index') }}" class="btn btn-primary">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard() {
    const tokenInput = document.getElementById('api_token');
    tokenInput.select();
    document.execCommand('copy');
    alert('Token copied to clipboard!');
}
</script>
@endpush