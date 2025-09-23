<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'filename',
        'path',
        'disk',
        'user_id',
        'status',
        'error_message',
        'expires_at',
        'downloaded_at',
        'slug', 
    ];

    protected $dates = [
        'expires_at',
        'downloaded_at',
    ];

    /**
     * Automatically generate a unique slug when creating a record.
     */
    protected static function booted()
    {
        static::creating(function ($download) {
            if (empty($download->slug)) {
                do {
                    $slug = Str::random(22);
                } while (Download::where('slug', $slug)->exists());

                $download->slug = $slug;
            }
        });
    }

    /**
     * Relationship: owner of the download.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: active downloads (not expired and ready).
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ready')
                     ->where('expires_at', '>=', Carbon::now());
    }

    /**
     * Scope: expired downloads.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                     ->orWhere('expires_at', '<', Carbon::now());
    }

    /**
     * Mark a download as used (when the user downloads it).
     */
    public function markAsDownloaded(): void
    {
        $this->update([
            'downloaded_at' => now(),
        ]);
    }

    // Accessor: return HTML with icon and label for the file type
    public function getTypeHtmlAttribute(): string
    {
        return match ($this->type) {
            'excel' => '<i class="fas fa-file-excel text-success"></i> Excel',
            'word'  => '<i class="fas fa-file-word text-primary"></i> Word',
            'csv'   => '<i class="fas fa-file-csv text-info"></i> CSV',
            'pdf'   => '<i class="fas fa-file-pdf text-danger"></i> PDF',
            default => '<i class="fas fa-file text-secondary"></i> ' . strtoupper($this->type),
        };
    }
}