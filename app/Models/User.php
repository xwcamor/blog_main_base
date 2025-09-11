<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'is_active',
        'is_deleted',
        'deleted_description',         
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
