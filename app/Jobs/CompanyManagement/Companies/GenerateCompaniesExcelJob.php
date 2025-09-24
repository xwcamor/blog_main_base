<?php

namespace App\Jobs\CompanyManagement\Companies;

use App\Models\Download;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CompanyManagement\Companies\CompaniesExport;
use Maatwebsite\Excel\Excel as ExcelFormat;

class GenerateCompaniesExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $userId;
    protected array $filters;
    protected string $locale;
    protected ?Download $download = null;

    public function __construct(int $userId, array $filters = [])
    {
        $this->userId  = $userId;
        $this->filters = $filters;
        $this->locale  = app()->getLocale(); // Capture locale at dispatch time
    }

    public function handle(): void
    {
        // Force translations with the locale captured at dispatch time
        app()->setLocale($this->locale);

        // Create download record
        $this->download = Download::create([
            'slug'       => Str::random(22),
            'user_id'    => $this->userId,
            'type'       => 'excel',
            'filename'   => $this->generateFilename(),
            'path'       => '',
            'disk'       => 'local',
            'status'     => 'processing',
            'expires_at' => now()->addDay(),
        ]);

        try {
            // Get filtered data
            $companies = Company::filter($this->filters)
                ->get();

            // Generate Excel as raw binary
            $content = Excel::raw(new CompaniesExport($companies), ExcelFormat::XLSX);

            // Save into downloads folder
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

            \Log::error('GenerateCompaniesExcelJob failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function generateFilename(): string
    {
        return __('companies.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
    }
}