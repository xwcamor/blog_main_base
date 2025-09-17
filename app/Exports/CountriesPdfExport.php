<?php

namespace App\Exports;

use App\Models\Country;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CountriesPdfExport
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function stream()
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

        $countries = $query->get();

        $pdf = PDF::loadView('setting_management.countries.pdf', compact('countries'));
        
        return $pdf->stream('countries.pdf');
    }
}
