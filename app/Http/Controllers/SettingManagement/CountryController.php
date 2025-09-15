<?php

// Source folder: app\Http\Controllers\SettingManagement\
namespace App\Http\Controllers\SettingManagement;

// Allow to use subfolders
use App\Http\Controllers\Controller;

// Use Models
use App\Models\Country; 

// Use Illuminates
use Illuminate\Http\Request;

// Use Request folder for validations
use App\Http\Requests\SettingManagement\Country\StoreRequest;
use App\Http\Requests\SettingManagement\Country\UpdateRequest;
use App\Http\Requests\SettingManagement\Country\DeleteRequest;


// Main class
class CountryController extends Controller
{
    // ------------------------------
    // INDEX
    // ------------------------------
    public function index(Request $request, Country $country)
    {   
        // Base query using scope 'notDeleted' from the model
        $query = $country::query();

        // All Filters
        // Filter for name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter for is_active
        if ($request->filled('is_active')) {
            $query->where('is_active', (int) $request->is_active);
        }

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $countries = $query->paginate(10)->appends($request->all());
        
        // Return data to view
        return view('setting_management.countries.index', compact('countries'));
    }

    // ------------------------------
    // CREATE
    // ------------------------------
    public function create()
    {
        // Displays file create.blade.php
        return view('setting_management.countries.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request)
    {   
        // Insert data on table
        $country = new Country();
        $country->name = $request->name;
        $country->created_by = auth()->id(); // User in session
        
        // Save array data
        $country->save();

        // Redirect to view with success message
        return redirect()
               ->route('setting_management.countries.index')
               ->with('success', __('global.created_success'));
    }

    // ------------------------------
    // SHOW
    // ------------------------------
    public function show(Country $country)
    {   
        // Displays file show.blade.php
        return view('setting_management.countries.show', compact('country'));
    }

    // ------------------------------
    // EDIT
    // ------------------------------
    public function edit(Country $country)
    {
        // Displays file edit.blade.php
        return view('setting_management.countries.edit', compact('country'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, Country $country)
    {
        // Update data on table
        $country->name      = $request->name;
        $country->is_active = $request->is_active;

        // Save array data
        $country->save();

        // Redirect to view with success message
        return redirect()
               ->route('setting_management.countries.index')
               ->with('success', __('global.updated_success'));
    }

    // ------------------------------
    // DELETE
    // ------------------------------
    public function delete(Country $country)
    {
        // Displays file delete.blade.php
        return view('setting_management.countries.delete', compact('country'));
    }
    
    // Action Update column is_deleted (hide from view)
    public function deleteSave(DeleteRequest $request, Country $country)
    {
        // Store reason and who deleted
        $country->deletion_reason = $request->deleted_description;
        $country->deleted_by = auth()->id();
        $country->is_active = false; // Optional: disable when deleting
        $country->save();

        // Soft delete (sets deleted_at)
        $country->delete();

        return redirect()
            ->route('setting_management.countries.index')
            ->with('success', __('global.deleted_success'));
    }

}