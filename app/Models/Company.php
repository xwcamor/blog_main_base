<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'num_doc',
    ];


    // Scope to filter by request parameters or plain array
    public function scopeFilter(Builder $query, Request|array $filters): Builder
    {
        // Convert array to Request if needed
        if (is_array($filters)) {
            $filters = new Request($filters);
        }

        // Filter for ruc
        if ($filters->filled('ruc')) {
            $query->where('ruc', 'like', '%' . $filters->ruc . '%');
        }

        // Filter for razon_social
        if ($filters->filled('razon_social')) {
            $query->where('razon_social', 'like', '%' . $filters->razon_social . '%');
        }

        // Filter for direccion
        if ($filters->filled('direccion')) {
            $query->where('direccion', 'like', '%' . $filters->direccion . '%');
        }

        // Filter for num_doc
        if ($filters->filled('num_doc')) {
            $query->where('num_doc', 'like', '%' . $filters->num_doc . '%');
        }

        // Order
        $sort = $filters->get('sort', 'id');
        $direction = $filters->get('direction', 'asc');

        if (in_array($sort, ['id', 'ruc', 'razon_social', 'direccion', 'num_doc']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}
