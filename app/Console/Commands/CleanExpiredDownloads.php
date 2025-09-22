<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class CleanExpiredDownloads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloads:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired downloads from storage and database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Find expired downloads (status expired or past expires_at)
        $expired = Download::where('expires_at', '<', now())
            ->orWhere('status', 'expired')
            ->get();

        $count = 0;

        foreach ($expired as $download) {
            // Delete file from storage if exists
            if ($download->path && Storage::disk($download->disk)->exists($download->path)) {
                Storage::disk($download->disk)->delete($download->path);
            }

            // Delete record from database
            $download->delete();
            $count++;
        }

        $this->info("Cleaned {$count} expired downloads.");

        return Command::SUCCESS;
    }
}