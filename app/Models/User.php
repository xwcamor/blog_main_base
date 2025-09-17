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
        'google_id',
        'email',
        'password',
        'name',
        'photo',  
        'slug',
        'is_active',
        'deleted_description',         
        'created_by',
        'deleted_by',
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
            ? '<span class="text-success">' . __('global.active') . '</span>'
            : '<span class="text-danger">' . __('global.inactive') . '</span>';
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
}
