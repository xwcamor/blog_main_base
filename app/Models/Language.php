<?php

// Namespace
namespace App\Models;

// Illuminates
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

// Main class
class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'iso_code',
        'slug',
        'is_active',
        'deletion_description',
        'created_by',
        'deleted_by',
    ];

    // Boot method to generate a unique slug when creating
    protected static function booted()
    {
        static::creating(function ($language) {
            do {
                $slug = Str::random(22);
            } while (Language::where('slug', $slug)->exists());

            $language->slug = $slug;
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

    /**
     * Scope to filter by request parameters
     */
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        // Filter for name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Filter for is_active
        if ($request->filled('is_active')) {
            $query->where('is_active', (int) $request->is_active);
        }

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }

}