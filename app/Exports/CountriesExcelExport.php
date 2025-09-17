<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountriesExcelExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Country::query();

        if ($this->request->filled('name')) {
            $query->where('name', 'like', '%' . $this->request->name . '%');
        }

        if ($this->request->filled('is_active')) {
            $query->where('is_active', (int) $this->request->is_active);
        }

        $sort = $this->request->get('sort', 'id');
        $direction = $this->request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            __('global.id'),
            __('global.name'),
            __('global.status'),
            __('global.created_at'),
        ];
    }

    public function map($country): array
    {
        return [
            $country->id,
            $country->name,
            $country->is_active ? __('global.active') : __('global.inactive'),
            $country->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
