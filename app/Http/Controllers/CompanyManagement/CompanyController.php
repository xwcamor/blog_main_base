<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Http\Requests\CompanyManagement\Company\StoreRequest;
use App\Http\Requests\CompanyManagement\Company\UpdateRequest;
use App\Http\Requests\CompanyManagement\Company\DeleteRequest;
use App\Services\CompanyManagement\CompanyService;
use App\Exports\CompanyManagement\Companies\CompaniesExport;
use App\Pdfs\CompanyManagement\CompaniesPdf;
use App\Exports\CompanyManagement\Companies\CompaniesWord;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Jobs\GenerateReportJob;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::filter($request)
            ->paginate(10)
            ->appends($request->all());

        return view('company_management.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('company_management.companies.create');
    }

    public function store(StoreRequest $request, CompanyService $service)
    {
        $service->create($request->validated());

        return redirect()->route('company_management.companies.index')
            ->with('success', __('global.created_success'));
    }

    public function show($slug)
    {
        $company = Company::withTrashed()->where('slug', $slug)->firstOrFail();
        return view('company_management.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('company_management.companies.edit', compact('company'));
    }

    public function update(UpdateRequest $request, Company $company, CompanyService $service)
    {
        $service->update($company, $request->validated());

        return redirect()->route('company_management.companies.index')
            ->with('success', __('global.updated_success'));
    }

    public function delete(Company $company)
    {
        return view('company_management.companies.delete', compact('company'));
    }

    public function deleteSave(DeleteRequest $request, Company $company, CompanyService $service)
    {
        $service->delete($company, $request->deleted_description);

        return redirect()->route('company_management.companies.index')
            ->with('success', __('global.deleted_success'));
    }

    public function destroy(Company $company, CompanyService $service)
    {
        $service->delete($company, 'Eliminado vía destroy');

        return redirect()->route('company_management.companies.index')
                        ->with('success', __('global.deleted_success'));
    }


    public function editAll(Request $request)
    {
        $query = Company::query();

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'num_doc', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $companies = $query->paginate(10)->appends($request->all());
        return view('company_management.companies.edit_all', compact('companies'));
    }

    public function updateInline(Request $request)
    {
        $allowedFields = ['name', 'num_doc', 'is_active'];
        if (!in_array($request->field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Campo no permitido'], 400);
        }

        $company = Company::findOrFail($request->id);
        $company->{$request->field} = $request->value;
        $company->save();

        return response()->json(['success' => true]);
    }

    public function exportExcel(Request $request)
    {
        $companies = Company::filter($request)->with('creator')->get();
        $filename = __('companies.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new CompaniesExport($companies), $filename);
    }

    public function exportPdf(Request $request)
    {
        $companies = Company::all(); 
        $filename = 'companies_export_' . now()->format('Ymd_His') . '.pdf';
        $pdfService = new CompaniesPdf();
        return $pdfService->generate($companies, $filename);
    }


    public function exportWord(Request $request, CompaniesWord $wordService)
    {
        $companies = Company::filter($request)->with('creator')->get();
        $filename = __('companies.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.docx';

        return $wordService->generate($companies, $filename);
    }

    public function fetchDni($num_doc)
    {
        try {
            $data = $this->fetchFromSunat($num_doc);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['name' => '', 'error' => $e->getMessage()]);
        }
    }

    private function fetchFromSunat($num_doc)
    {
        $token = env('API_PERU_TOKEN'); // lee directamente del .env
        if (!$token) {
            throw new \Exception('No se ha configurado API_PERU_TOKEN');
        }

        $response = Http::withToken($token)
            ->withoutVerifying() // evita error SSL en desarrollo
            ->get("https://api.apis.net.pe/v1/dni?numero={$num_doc}");

        if ($response->successful()) {
            $result = $response->json();
            $fullName = trim(
                ($result['nombres'] ?? '') . ' ' .
                ($result['apellidoPaterno'] ?? '') . ' ' .
                ($result['apellidoMaterno'] ?? '')
            );
            return ['name' => $fullName];
        }

        throw new \Exception('DNI no encontrado en RENIEC.');
    }



}
