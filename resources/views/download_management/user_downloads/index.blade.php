@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ __('global.my_downloads') }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('global.filename') }}</th>
                <th>{{ __('global.type') }}</th>
                <th>{{ __('global.status') }}</th>
                <th>{{ __('global.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($downloads as $download)
                <tr>
                    <td>{{ $download->filename }}</td>
                    <td>{{ strtoupper($download->type) }}</td>
                    <td>
                        @if($download->status === 'ready')
                            <span class="badge bg-success">Ready</span>
                        @elseif($download->status === 'processing')
                            <span class="badge bg-warning text-dark">Processing</span>
                        @elseif($download->status === 'expired')
                            <span class="badge bg-secondary">Expired</span>
                        @else
                            <span class="badge bg-danger">Failed</span>
                        @endif
                    </td>
                    <td>
                        @if($download->status === 'ready')
                            <a href="{{ route('download_management.user_downloads.download', $download->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">{{ __('global.no_downloads') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $downloads->links() }}
</div>
@endsection
