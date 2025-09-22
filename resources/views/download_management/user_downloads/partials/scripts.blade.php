<script>
$(document).ready(function() {
    let refreshInterval;
    let isRefreshing = false;
    let autoRefreshTimeout = 2 * 60 * 1000; // 2 minutes
    let startTime = Date.now();
    let hasShownReadyNotification = false;

    function startAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }

        refreshInterval = setInterval(function() {
            // Check if timeout reached
            if (Date.now() - startTime > autoRefreshTimeout) {
                stopAutoRefresh();
                showNotification('{{ __("global.auto_refresh_stopped") }}', 'info');
                return;
            }

            if (isRefreshing) return;

            isRefreshing = true;

            $.get('{{ route("download_management.user_downloads.latest") }}')
                .done(function(data) {
                    $('#downloads-container').html(data.html);

                    // Check if we have ready downloads that weren't there before
                    let hasReadyDownloads = $(data.html).find('.badge.bg-success').length > 0;

                    if (!data.has_processing) {
                        stopAutoRefresh();
                        if (hasReadyDownloads && !hasShownReadyNotification) {
                            showNotification('{{ __("global.download_ready") }}', 'success');
                            hasShownReadyNotification = true;
                        }
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
            $('#auto-refresh-indicator').addClass('d-none');
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

    // Start auto-refresh always for 2 minutes
    startAutoRefresh();
    $('#auto-refresh-indicator').removeClass('d-none');
    console.log('Auto-refresh started - will run for 2 minutes');

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