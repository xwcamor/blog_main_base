<?php

namespace App\Http\Controllers\SettingManagement;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\SettingManagement\Country\StoreRequest;
use App\Http\Requests\SettingManagement\Country\UpdateRequest;
use App\Http\Requests\SettingManagement\Country\DeleteRequest;
use App\Exports\CountriesExcelExport;
use App\Exports\CountriesPdfExport;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', (int) $request->is_active);
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $countries = $query->paginate(10)->appends($request->all());
        
        return view('setting_management.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('setting_management.countries.create');
    }

    public function store(StoreRequest $request)
    {   
        $country = new Country();
        $country->name = $request->name;
        $country->created_by = auth()->id();
        $country->save();

        return redirect()
               ->route('setting_management.countries.index')
               ->with('success', __('global.created_success'));
    }

    public function show($slug)
    {
        $country = Country::withTrashed()->where('slug', $slug)->firstOrFail();
        return view('setting_management.countries.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('setting_management.countries.edit', compact('country'));
    }

    public function update(UpdateRequest $request, Country $country)
    {
        $country->name      = $request->name;
        $country->is_active = $request->is_active;
        $country->save();

        return redirect()
               ->route('setting_management.countries.index')
               ->with('success', __('global.updated_success'));
    }

    public function delete(Country $country)
    {
        return view('setting_management.countries.delete', compact('country'));
    }
    
    public function deleteSave(DeleteRequest $request, Country $country)
    {
        $country->deleted_description = $request->deleted_description;
        $country->deleted_by = auth()->id();
        $country->is_active = false; 
        $country->save();
        $country->delete();

        return redirect()
            ->route('setting_management.countries.index')
            ->with('success', __('global.deleted_success'));
    }

    public function liveEdit(Request $request)
    {
        $query = Country::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', (int) $request->is_active);
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $countries = $query->paginate(10)->appends($request->all());

        return view('setting_management.countries.live_edit', compact('countries'));
    }
    
    public function updateInline(Request $request)
    {
        $country = Country::findOrFail($request->id);
        $country->{$request->field} = $request->value;
        $country->save();

        return response()->json(['success' => true]);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new CountriesExcelExport($request), 'countries.xlsx');
    }

    public function exportPdf(Request $request)
    {
        return (new CountriesPdfExport($request))->stream();
    }
}
