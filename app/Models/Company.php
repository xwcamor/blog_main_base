<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ruc',
        'name',
        'slug',
    ];

    // Generar slug único al crear
    protected static function booted()
    {
        static::creating(function ($company) {
            do {
                $slug = Str::random(22);
            } while (Company::where('slug', $slug)->exists());

            $company->slug = $slug;
        });
    }

    // Usar slug para route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
