<table class="table table-bordered" id="downloads-table">
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
                <td>{!! $download->type_html !!}</td>

                <td>
                    @if($download->status === 'ready')
                        <span class="badge bg-success">{{ __('global.ready') }}</span>
                    @elseif($download->status === 'processing')
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-spinner fa-spin"></i> {{ __('global.processing') }}
                        </span>
                    @elseif($download->status === 'expired')
                        <span class="badge bg-secondary">{{ __('global.expired') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('global.failed') }}</span>
                    @endif
                </td>
                <td>
                    @if($download->status === 'ready')
                        <a href="{{ route('download_management.user_downloads.download', $download->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> {{ __('global.download') }}
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">{{ __('global.no_downloads') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($downloads->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $downloads->links() }}
    </div>
@endif