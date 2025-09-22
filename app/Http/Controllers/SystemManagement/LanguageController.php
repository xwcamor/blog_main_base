<?php

// Namespace
namespace App\Http\Controllers\SystemManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Language;

// Requests
use App\Http\Requests\SystemManagement\Language\StoreRequest;
use App\Http\Requests\SystemManagement\Language\UpdateRequest;
use App\Http\Requests\SystemManagement\Language\DeleteRequest;

// Services
use App\Services\SystemManagement\LanguageService;

// Excel
use App\Exports\SystemManagement\Languages\LanguagesExport;
use Maatwebsite\Excel\Facades\Excel;

// PDF
use App\Pdfs\SystemManagement\LanguagesPdf;
use Barryvdh\DomPDF\Facade\Pdf;

// Word
use App\Exports\SystemManagement\Languages\LanguagesWord;

// Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Job
use App\Jobs\GenerateReportJob;

// Main class
class LanguageController extends Controller
{
    // Action Index
    public function index(Request $request)
    {
        // Base query using filter scope from the model
        $languages = Language::filter($request)
            ->paginate(10) // Pagination for 10 rows
            ->appends($request->all());
 
        // Return data to index
        return view('system_management.languages.index', compact('languages'));
    }

    // Action Create
    public function create()
    {
        // Displays create.blade.php
        return view('system_management.languages.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request, LanguageService $service)
    {
        // Using Service from app/Services
        $service->create($request->validated());

        // Redirect to view with success message 
        return redirect()
            ->route('system_management.languages.index')
            ->with('success', __('global.created_success'));
    }

    // Action Show
    public function show($slug)
    {
        // Find by Slug
        $language = Language::withTrashed()->where('slug', $slug)->firstOrFail();
        
        // Displays show.blade.php
        return view('system_management.languages.show', compact('language'));
    }

    // Action Edit
    public function edit(Language $language)
    {
        // Displays edit.blade.php
        return view('system_management.languages.edit', compact('language'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, Language $language, LanguageService $service)
    {
        // Using Service from app/Services
        $service->update($language, $request->validated());
        
        // Redirect to view with success message 
        return redirect()
            ->route('system_management.languages.index')
            ->with('success', __('global.updated_success'));
    }

    // Action Delete
    public function delete(Language $language)
    {
        // Displays delete.blade.php
        return view('system_management.languages.delete', compact('language'));
    }

    // Action Update column deleted_at (hide from view)
    public function deleteSave(DeleteRequest $request, Language $language, LanguageService $service)
    {
        // Using Service from app/Services
        $service->delete($language, $request->deleted_description);
        
        // Redirect to view with success message 
        return redirect()
            ->route('system_management.languages.index')
            ->with('success', __('global.deleted_success'));
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

        return view('system_management.languages.edit_all', compact('languages'));
    }

    // Action Update inline
    public function updateInline(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->{$request->field} = $request->value;
        $language->save();

        return response()->json(['success' => true]);
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        // Set locale for this request
        $currentLocale = LaravelLocalization::getCurrentLocale();
        app()->setLocale($currentLocale);

        // Data from filters
        $languages = Language::filter($request)->with('creator')->get();

        // Generate filename
        $filename = __('languages.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // Export file
        return Excel::download(new LanguagesExport($languages), $filename);
    }

    // Export Pdf
    public function exportPdf2(Request $request, LanguagesPdf $pdfService)
    {
        // Set locale for this request
        $currentLocale = LaravelLocalization::getCurrentLocale();
        app()->setLocale($currentLocale);

        // Data from filters
        $languages = Language::filter($request)->with('creator')->get();

        // Generate filename
        $filename = __('languages.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        // Export file
        return $pdfService->generate($languages, $filename);
    }

    public function exportPdf(Request $request)
    {
        // You can pass filters or data to the Job
        $filters = $request->all();

        // Get current locale from URL
        $currentLocale = LaravelLocalization::getCurrentLocale();

        // Dispatch the job to the queue with locale
        GenerateReportJob::dispatch(auth()->id(), 'pdf', $filters, $currentLocale);

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.pdf_generation_started'));
    }


    // Export Word
    public function exportWord(Request $request, LanguagesWord $wordService)
    {
        // Set locale for this request
        $currentLocale = LaravelLocalization::getCurrentLocale();
        app()->setLocale($currentLocale);

        $languages = Language::filter($request)->with('creator')->get();

        $filename = __('languages.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.docx';

        return $wordService->generate($languages, $filename);
    }
}