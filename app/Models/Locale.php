<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'code',
        'name',
        'language_id',
        'is_active',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    // Relación con Language
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
