<?php

// Main namespace
namespace App\Models;

// Use Illuminates
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

// Main class
class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'deletion_description',
        'created_by',
        'deleted_by',      
    ];
    
    // Boot method to generate a unique slug when creating
    protected static function booted()
    {
        static::creating(function ($country) {
            do {
                $slug = Str::random(22);
            } while (Country::where('slug', $slug)->exists());

            $country->slug = $slug;
        });
    }    
    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationships for audit.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    
    /**
     * Accessor: return HTML state (active/inactive).
     */
    public function getStateHtmlAttribute()
    {
        return $this->is_active
            ? '<span class="badge badge-success">' . __('global.active') . '</span>'
            : '<span class="badge badge-danger">' . __('global.inactive') . '</span>';
    }

    /**
     * Accessor: return plain text state (active/inactive).
     */
    public function getStateTextAttribute()
    {
        return $this->is_active
            ? __('global.active')
            : __('global.inactive');
    }

    /**
     * Scope to filter out deleted records.
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }       
}