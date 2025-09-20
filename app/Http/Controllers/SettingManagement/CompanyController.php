<?php

namespace App\Http\Controllers\SettingManagement;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index(Request $request, Company $company)
    {
        $query = $company::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('ruc')) {
            $query->where('ruc', $request->ruc);
        }

        $companies = $query->paginate(10)->appends($request->all());

        return view('setting_management.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('setting_management.companies.create');
    }

    public function store(Request $request)
    {
        $data = $this->fetchFromSunat($request->ruc);

        $company = Company::withTrashed()->where('ruc', $request->ruc)->first();

        if ($company) {
            if ($company->trashed()) {
                $company->restore();
                $company->update([
                    'name' => $data['name'] ?? ''
                ]);
            } else {
                return redirect()->back()->withErrors('El RUC ya está registrado.');
            }
        } else {
            Company::create([
                'ruc'  => $request->ruc,
                'name' => $data['name'] ?? '',
            ]);
        }

        return redirect()->route('setting_management.companies.index')
            ->with('success', 'Company created or restored successfully.');
    }

    public function edit(Company $company)
    {
        return view('setting_management.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $company->update([
            'ruc'  => $request->ruc,
            'name' => $request->name,
        ]);

        return redirect()->route('setting_management.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function show(Company $company)
    {
        return view('setting_management.companies.show', compact('company'));
    }

    public function delete(Company $company)
    {
        return view('setting_management.companies.delete', compact('company'));
    }

    public function deleteSave(Request $request, Company $company)
    {
        $company->forceDelete();
        return redirect()->route('setting_management.companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    public function fetchRuc(Request $request)
    {
        $ruc = $request->input('ruc');

        try {
            $data = $this->fetchFromSunat($ruc);
            return response()->json([
                'success' => !empty($data),
                'name' => $data['name'] ?? ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'name' => '',
                'error' => $e->getMessage()
            ]);
        }
    }

    private function fetchFromSunat($ruc)
    {
        $token = env('API_PERU_TOKEN');

        $response = Http::withToken($token)
            ->get("https://api.apis.net.pe/v1/ruc?numero={$ruc}");

        if ($response->successful()) {
            $result = $response->json();
            return [
                'name' => $result['nombre'] ?? ''
            ];
        }

        return [];
    }
}
