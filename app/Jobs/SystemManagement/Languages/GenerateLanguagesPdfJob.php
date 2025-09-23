<?php

namespace App\Jobs\SystemManagement\Languages;

use App\Models\Download;
use App\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GenerateLanguagesPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $filters;
    protected $locale;
    protected $download;

    public function __construct(int $userId, array $filters = [])
    {
        $this->userId  = $userId;
        $this->filters = $filters;
        $this->locale  = app()->getLocale(); // capture locale at dispatch time
    }

    public function handle(): void
    {
        // Force translations to use the locale captured at dispatch time
        app()->setLocale($this->locale);

        // Create download record
        $this->download = Download::create([
            'slug'       => Str::random(22),
            'user_id'    => $this->userId,
            'type'       => 'pdf',
            'filename'   => $this->generateFilename(),
            'path'       => '',
            'disk'       => 'local',
            'status'     => 'processing',
            'expires_at' => now()->addDay(),
        ]);

        try {
            // Get filtered data (now scope accepts array directly)
            $languages = Language::filter($this->filters)
                ->with('creator')
                ->get();

            // Generate PDF with options
            $pdf = Pdf::loadView('system_management.languages.pdf.template', compact('languages'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                ]);

            $content = $pdf->output();

            // Save file
            $path = 'downloads/' . $this->download->filename;
            Storage::disk($this->download->disk)->put($path, $content);

            // Update record
            $this->download->update([
                'path'   => $path,
                'status' => 'ready',
            ]);

        } catch (\Exception $e) {
            $this->download->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            \Log::error('GenerateLanguagesPdfJob failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function generateFilename(): string
    {
        return __('languages.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
    }
}