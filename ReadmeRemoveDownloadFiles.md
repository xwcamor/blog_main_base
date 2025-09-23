# 📘 Laravel Downloads Cleanup (Scheduler & Cron)

## ✅ Purpose
Avoid filling the server with old exported files (PDF, Excel, Word, etc.).  
Expired downloads (after 1 day) will be removed automatically from **database** and **storage**.

---

## ⚙️ 1. Create the Command
File: `app/Console/Commands/CleanExpiredDownloads.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class CleanExpiredDownloads extends Command
{
    /** @var string */
    protected $signature = 'downloads:clean';

    /** @var string */
    protected $description = 'Delete expired downloads and their files from storage';

    public function handle()
    {
        $expired = Download::expired()->get();

        foreach ($expired as $download) {
            // Delete physical file if exists
            if ($download->path && Storage::disk($download->disk)->exists($download->path)) {
                Storage::disk($download->disk)->delete($download->path);
            }

            // Delete record
            $download->delete();
        }

        $this->info("Expired downloads cleaned: " . $expired->count());
    }
}
```

---

## ⚙️ 2. Register the Command in Kernel
File: `app/Console/Kernel.php`

```php
protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
{
    // Run cleanup daily at midnight
    $schedule->command('downloads:clean')->daily();
}
```

---

## ⚙️ 3. Configure Cron on the Server
On your Linux server, edit cron with:

```bash
crontab -e
```

Add this line (adjust path):

```bash
* * * * * php /var/www/your-project/artisan schedule:run >> /dev/null 2>&1
```

- Runs every minute.  
- Laravel decides when to trigger `downloads:clean` (daily).  

---

## ⚙️ 4. Test the Command
Run manually:

```bash
php artisan downloads:clean
```

You should see:

```
Expired downloads cleaned: X
```

---

## ⚙️ 5. Flow Recap
1. User exports → record is saved in `downloads`.  
2. After 1 day → download expires (`expires_at`).  
3. Cron triggers Laravel Scheduler.  
4. Command `downloads:clean` deletes expired files + records.  

---

✅ With this setup, your **downloads table stays clean** and your **storage won’t fill up**.
