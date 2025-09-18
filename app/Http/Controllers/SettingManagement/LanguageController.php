<?php

// Source folder: app\Http\Controllers\SettingManagement\
namespace App\Http\Controllers\SettingManagement;

// Allow to use subfolders
use App\Http\Controllers\Controller;

// Use Models
use App\Models\Language;

// Use Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Use Request folder for validations
use App\Http\Requests\SettingManagement\Language\StoreRequest;
use App\Http\Requests\SettingManagement\Language\UpdateRequest;
use App\Http\Requests\SettingManagement\Language\DeleteRequest;

// Use Fast Excel
use Rap2hpoutre\FastExcel\FastExcel;

// Use DomPDF
use Barryvdh\DomPDF\Facade\Pdf;


// Main class
class LanguageController extends Controller
{
    // ------------------------------
    // INDEX
    // ------------------------------
    public function index(Request $request, Language $language)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $language::query();

        // Apply filters
        $query = $this->applyFilters($query, $request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $languages = $query->paginate(10)->appends($request->all());

        // Return data to view
        return view('setting_management.languages.index', compact('languages'));
    }

    // ------------------------------
    // CREATE
    // ------------------------------
    public function create()
    {
        // Displays file create.blade.php
        return view('setting_management.languages.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request)
    {
        // Insert data on table
        $language = new Language();
        $language->name = $request->name;
        $language->locale = $request->locale;
        $language->flag = $request->flag;
        $language->is_active = $request->is_active;
        $language->created_by = auth()->id(); // User in session

        // Save array data
        $language->save();

        // Redirect to view with success message
        return redirect()
               ->route('setting_management.languages.index')
               ->with('success', __('global.created_success'));
    }

    // ------------------------------
    // SHOW
    // ------------------------------
    public function show($slug)
    {
        $language = Language::withTrashed()->where('slug', $slug)->firstOrFail();

        return view('setting_management.languages.show', compact('language'));
    }

    // ------------------------------
    // EDIT
    // ------------------------------
    public function edit(Language $language)
    {
        // Displays file edit.blade.php
        return view('setting_management.languages.edit', compact('language'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, Language $language)
    {
        // Update data on table
        $language->name      = $request->name;
        $language->locale    = $request->locale;
        $language->flag      = $request->flag;
        $language->is_active = $request->is_active;

        // Save array data
        $language->save();

        // Redirect to view with success message
        return redirect()
               ->route('setting_management.languages.index')
               ->with('success', __('global.updated_success'));
    }

    // ------------------------------
    // DELETE
    // ------------------------------
    public function delete(Language $language)
    {
        // Displays file delete.blade.php
        return view('setting_management.languages.delete', compact('language'));
    }

    // Action Update column is_deleted (hide from view)
    public function deleteSave(DeleteRequest $request, Language $language)
    {
        // Store reason and who deleted
        $language->deleted_description = $request->deleted_description;
        $language->deleted_by = auth()->id();
        $language->is_active = false;
        $language->save();

        // Soft delete (sets deleted_at)
        $language->delete();

        return redirect()
            ->route('setting_management.languages.index')
            ->with('success', __('global.deleted_success'));
    }


    // Live Edit View
    public function liveEdit(Request $request, Language $language)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $language::query();

        // Apply filters
        $query = $this->applyFilters($query, $request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $languages = $query->paginate(10)->appends($request->all());

        return view('setting_management.languages.live_edit', compact('languages'));
    }

    // Edit All View (like index but with inline editing)
    public function editAll(Request $request, Language $language)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $language::query();

        // Apply filters
        $query = $this->applyFilters($query, $request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $languages = $query->paginate(10)->appends($request->all());

        return view('setting_management.languages.edit_all', compact('languages'));
    }

    // Action Update inline
    public function updateInline(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->{$request->field} = $request->value;
        $language->save();

        return response()->json(['success' => true]);
    }

    // Export Excel using Fast Excel
    public function exportExcel(Request $request)
    {
        // Base query using scope 'notDeleted' from the model
        $query = Language::query()->with('creator');

        // Apply same filters as index
        $query = $this->applyFilters($query, $request);

        // Get all filtered records (no pagination)
        $languages = $query->get();

        // Generate filename with timestamp
        $filename = __('languages.export_filename') . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Transform data for Excel export
        $data = $languages->map(function ($language) {
            return [
                __('languages.id') => $language->id,
                __('languages.name') => $language->name,
                __('languages.is_active') => $language->state_text,
                __('global.created_at') => $language->created_at->format('Y-m-d H:i:s'),
                __('global.created_by') => $language->creator->name ?? '-',
            ];
        });

        // Export using Fast Excel
        return (new FastExcel($data))->download($filename);
    }

    // Export PDF using DomPDF
    public function exportPdf(Request $request)
    {
        // Base query using scope 'notDeleted' from the model
        $query = Language::query()->with('creator');

        // Apply same filters as index
        $query = $this->applyFilters($query, $request);

        // Get all filtered records (no pagination)
        $languages = $query->get();

        // Generate filename with timestamp
        $filename = __('languages.export_filename') . '_' . date('Y-m-d_H-i-s') . '.pdf';

        // Load PDF view with data
        $pdf = Pdf::loadView('setting_management.languages.pdf.template', compact('languages'));

        // Configure PDF options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false
        ]);

        // Return PDF for download
        return $pdf->download($filename);
    }

    // Private method to centralize filter logic
    private function applyFilters($query, Request $request)
    {
        // Filter for name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter for is_active
        if ($request->filled('is_active')) {
            $query->where('is_active', (int) $request->is_active);
        }

        return $query;
    }

}