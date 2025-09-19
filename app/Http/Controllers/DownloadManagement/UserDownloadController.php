<?php

// Namespace
namespace App\Http\Controllers\DownloadManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Download;

// Requests
use Illuminate\Http\Request;

// Services
use App\Services\DownloadManagement\DownloadService;

// Illuminates
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Main class
class UserDownloadController extends Controller
{
    /**
     * Action Index
     * Show only active downloads for the authenticated user
     */
    public function index(Request $request)
    {
        $downloads = Download::active()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('download_management.user_downloads.index', compact('downloads'));
    }

    /**
     * Action Download
     * Allow user to download file if not expired
     */
    public function download($id)
    {
        $download = Download::where('user_id', Auth::id())
            ->where('status', 'ready')
            ->where('expires_at', '>=', now())
            ->findOrFail($id);

        // Mark as downloaded
        $download->markAsDownloaded();

        return Storage::disk($download->disk)->download($download->path, $download->filename);
    }

    /**
     * Action Delete (user can manually remove from their list)
     */
    public function delete($id, DownloadService $service)
    {
        $download = Download::where('user_id', Auth::id())->findOrFail($id);

        $service->expire($download);

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.deleted_success'));
    }
}