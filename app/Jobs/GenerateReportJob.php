<?php

namespace App\Jobs;

use App\Models\Download;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

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
            'filename'   => 'report_' . now()->format('Y-m-d_H-i-s') . '.' . $this->extension(),
            'path'       => '', // will be filled later
            'disk'       => 'local',
            'status'     => 'processing',
            'expires_at' => now()->addDay(), // ⬅️ expires in 24h
        ]);

        try {
            // 2. Generate file (mock example)
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
        }
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
     * Mock generator – replace with real PDF/Excel/Word export.
     */
    protected function generateContent(): string
    {
        if ($this->type === 'pdf') {
            return 'PDF content for report';
        } elseif ($this->type === 'excel') {
            return 'Excel content for report';
        } elseif ($this->type === 'word') {
            return 'Word content for report';
        }

        return 'Unknown format';
    }
}