<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
    ];

    protected $dates = [
        'expires_at',
        'downloaded_at',
    ];

    /**
     * Relación: dueño de la descarga.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: descargas vigentes (no vencidas).
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ready')
                     ->where('expires_at', '>=', Carbon::now());
    }

    /**
     * Scope: descargas expiradas.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                     ->orWhere('expires_at', '<', Carbon::now());
    }

    /**
     * Marcar descarga como usada.
     */
    public function markAsDownloaded(): void
    {
        $this->update([
            'downloaded_at' => now(),
        ]);
    }
}