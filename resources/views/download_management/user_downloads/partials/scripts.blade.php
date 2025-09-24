<script>
$(document).ready(function() {
    let refreshInterval;
    let isRefreshing = false;
    
    function startAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        
        refreshInterval = setInterval(function() {
            if (isRefreshing) return;
            
            isRefreshing = true;
            
            $.get('{{ route("download_management.user_downloads.latest") }}')
                .done(function(data) {
                    $('#downloads-container').html(data.html);
                    
                    if (!data.has_processing) {
                        stopAutoRefresh();
                        showNotification('{{ __("global.download_ready") }}', 'success');
                    }
                })
                .fail(function() {
                    console.log('Failed to refresh downloads');
                })
                .always(function() {
                    isRefreshing = false;
                });
        }, 3000);
    }
    
    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
            refreshInterval = null;
        }
    }
    
    function showNotification(message, type) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                text: message,
                icon: type,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
    }
    
    // Start auto-refresh if there are processing files
    @if($downloads->where('status', 'processing')->count() > 0)
        startAutoRefresh();
        console.log('Auto-refresh started - processing files detected');
    @endif
    
    // Stop auto-refresh when user leaves page
    $(window).on('beforeunload', function() {
        stopAutoRefresh();
    });
    
    // Manual refresh button functionality
    $('#refresh-downloads').on('click', function() {
        $(this).prop('disabled', true);
        
        $.get('{{ route("download_management.user_downloads.latest") }}')
            .done(function(data) {
                $('#downloads-container').html(data.html);
                
                if (data.has_processing && !refreshInterval) {
                    startAutoRefresh();
                }
            })
            .always(function() {
                $('#refresh-downloads').prop('disabled', false);
            });
    });
});
</script>