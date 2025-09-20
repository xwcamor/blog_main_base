<?php

namespace App\Jobs;

use App\Models\Download;
use App\Models\Language;
use App\Pdfs\SystemManagement\LanguagesPdf;
use App\Exports\SystemManagement\Languages\LanguagesExport;
use App\Exports\SystemManagement\Languages\LanguagesWord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $type;       // pdf, excel, word
    protected $data;       // data to export

    protected $download;   // download record

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, string $type, array $data = [])
    {
        $this->userId = $userId;
        $this->type   = $type;
        $this->data   = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Create download record as pending
        $this->download = Download::create([
            'user_id'    => $this->userId,
            'type'       => $this->type,
            'filename'   => $this->generateFilename(),
            'path'       => '', // will be filled later
            'disk'       => 'local',
            'status'     => 'processing',
            'expires_at' => now()->addDay(), // expires in 24h
        ]);

        try {
            // 2. Generate file content
            $content = $this->generateContent();

            // 3. Save file into storage
            $path = 'downloads/' . $this->download->filename;
            Storage::disk($this->download->disk)->put($path, $content);

            // 4. Update record as ready
            $this->download->update([
                'path'   => $path,
                'status' => 'ready',
            ]);
        } catch (\Exception $e) {
            // 5. If something fails, mark as failed
            $this->download->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            
            // Log the error for debugging
            \Log::error('GenerateReportJob failed', [
                'user_id' => $this->userId,
                'type' => $this->type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Generate appropriate filename based on type and current date.
     */
    protected function generateFilename(): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        
        return match ($this->type) {
            'pdf' => __('languages.export_filename') . '_' . $timestamp . '.pdf',
            'excel' => __('languages.export_filename') . '_' . $timestamp . '.xlsx',
            'word' => __('languages.export_filename') . '_' . $timestamp . '.docx',
            default => 'report_' . $timestamp . '.pdf',
        };
    }

    /**
     * Decide extension based on type.
     */
    protected function extension(): string
    {
        return match ($this->type) {
            'excel' => 'xlsx',
            'word'  => 'docx',
            default => 'pdf',
        };
    }

    /**
     * Generate real content based on type using existing services.
     */
    protected function generateContent(): string
    {
        // Create a mock request object with filters
        $request = new Request($this->data);
        
        // Get filtered languages data
        $languages = Language::filter($request)->with('creator')->get();

        if ($this->type === 'pdf') {
            return $this->generatePdfContent($languages);
        } elseif ($this->type === 'excel') {
            return $this->generateExcelContent($languages);
        } elseif ($this->type === 'word') {
            return $this->generateWordContent($languages);
        }

        throw new \Exception('Unknown export type: ' . $this->type);
    }

    /**
     * Generate PDF content using LanguagesPdf service.
     */
    protected function generatePdfContent($languages): string
    {
        try {
            // Set locale for translations
            app()->setLocale('es');
            
            // Generate PDF and get the binary content
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'system_management.languages.pdf.template',
                compact('languages')
            )->setPaper('a4', 'portrait')
             ->setOptions([
                 'defaultFont' => 'sans-serif',
                 'isHtml5ParserEnabled' => true,
                 'isRemoteEnabled' => false,
             ]);

            $content = $pdf->output();
            
            // Log success for debugging
            \Log::info('PDF generated successfully', [
                'size' => strlen($content),
                'languages_count' => $languages->count()
            ]);
            
            return $content;
            
        } catch (\Exception $e) {
            \Log::error('PDF generation failed in Job', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Generate Excel content using LanguagesExport.
     */
    protected function generateExcelContent($languages): string
    {
        $export = new LanguagesExport($languages);
        
        // Create a temporary file to get the content
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_export');
        Excel::store($export, basename($tempFile), 'local', \Maatwebsite\Excel\Excel::XLSX);
        
        $content = Storage::disk('local')->get(basename($tempFile));
        Storage::disk('local')->delete(basename($tempFile));
        
        return $content;
    }

    /**
     * Generate Word content using LanguagesWord service.
     */
    protected function generateWordContent($languages): string
    {
        $wordService = new LanguagesWord();
        
        // Create a temporary file to get the content
        $tempFile = tempnam(sys_get_temp_dir(), 'word_export') . '.docx';
        $wordService->generate($languages, $tempFile);
        
        $content = file_get_contents($tempFile);
        unlink($tempFile);
        
        return $content;
    }
}