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
use Spatie\Permission\Models\Permission;


// Main class
class SystemModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'permission_key',
        'slug',
        'deletion_description',
        'created_by',
        'deleted_by',
    ];

    // Boot method to generate a unique slug when creating
    protected static function booted()
    {
        static::creating(function ($system_module) {
            do {
                $slug = Str::random(22);
            } while (SystemModule::where('slug', $slug)->exists());

            $system_module->slug = $slug;
        });
    }

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationships for audit.
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Set Attribute accessor for name and permission_key
    public function setNameAttribute($value)
    {
        // Save on PascalCase singular
        $this->attributes['name'] = Str::studly(Str::singular($value));

        // Generate permission_key en snake_case plural
        $snake = Str::snake(Str::singular($value));
        $this->attributes['permission_key'] = Str::plural($snake);
    }

    // Accessor to get related permissions
    public function getPermissionsAttribute()
    {
        return Permission::where('name', 'like', "{$this->permission_key}.%")
                        ->orderBy('id')
                        ->get();
    }

    // Scope to filter out deleted records.
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    // Scope to filter by request parameters
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        // Filter for name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter for permission_key
        if ($request->filled('permission_key')) {
            $query->where('permission_key', 'like', '%' . $request->permission_key . '%');
        }

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'permission_key']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}
