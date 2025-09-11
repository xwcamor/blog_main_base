<?php

// Main namespace
namespace App\Models;

// Use Illuminates
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// Main class
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'is_deleted',
        'deleted_description',          
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
    
    // Scope to get only not deleted from the table
    public function scopeNotDeleted($query) {
        return $query->where('is_deleted', false);
    }
    
    // Accessor to get HTML for is_active
    public function getStateHtmlAttribute()
    {
        if ($this->is_active === 1 || $this->is_active === true) {
            return '<span class="text-success">Activo</span>';
        } elseif ($this->is_active === 0 || $this->is_active === false) {
            return '<span class="text-danger">Inactivo</span>';
        }

    }   

    // Accessor to get HTML for is_active
    public function getStateTextAttribute()
    {
        if ($this->is_active === 1 || $this->is_active === true) {
            return 'Activo';
        } elseif ($this->is_active === 0 || $this->is_active === false) {
            return 'Inactivo';
        }

    }       
}
