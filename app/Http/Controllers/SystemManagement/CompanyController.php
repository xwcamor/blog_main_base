<?php

namespace App\Http\Controllers\SystemManagement;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\SystemManagement\Company\StoreRequest;
use App\Http\Requests\SystemManagement\Company\UpdateRequest;

class CompanyController extends Controller
{
    public function index(Request $request, Company $company)
    {
        $query = $company::query();

        if ($request->filled('razon_social')) {
            $query->where('razon_social', 'like', '%' . $request->razon_social . '%');
        }

        if ($request->filled('direccion')) {
            $query->where('direccion', 'like', '%' . $request->direccion . '%');
        }

        if ($request->filled('ruc')) {
            $query->where('ruc', $request->ruc);
        }

        $companies = $query->paginate(10)->appends($request->all());

        return view('system_management.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('system_management.companies.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $this->fetchFromSunat($request->ruc);

        Company::create([
            'ruc'          => $request->ruc,
            'razon_social' => $data['razon_social'] ?? '',
            'direccion'    => $data['direccion'] ?? '',
        ]);

        return redirect()->route('system_management.companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('system_management.companies.edit', compact('company'));
    }

    public function show(Company $company)
    {
        return view('system_management.companies.show', compact('company'));
    }

    public function update(UpdateRequest $request, Company $company)
    {
        $company->update([
            'ruc'          => $request->ruc,
            'razon_social' => $request->razon_social,
            'direccion'    => $request->direccion,
        ]);

        return redirect()->route('system_management.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function delete(Company $company)
    {
        return view('system_management.companies.delete', compact('company'));
    }

    public function deleteSave(Request $request, Company $company)
    {
        $company->delete();

        return redirect()->route('system_management.companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    /**
     * Llamada AJAX para autocompletar RUC
     */
    public function fetchRuc($ruc)
    {
        if (!preg_match('/^\d{11}$/', $ruc)) {
            return response()->json(['error' => 'RUC inválido'], 400);
        }

        $data = $this->fetchFromSunat($ruc);

        return response()->json($data);
    }


    /**
     * Consulta a la API de SUNAT para RUC usando token
     */
    private function fetchFromSunat($ruc)
    {
        $token = env('API_PERU_TOKEN'); // Agrega tu token en .env

        // Try v2 endpoint first
        $response = Http::withToken($token)
            ->get("https://api.apis.net.pe/v2/sunat/ruc?numero={$ruc}");

        // If v2 fails, try v1 endpoint
        if (!$response->successful()) {
            $response = Http::withToken($token)
                ->get("https://api.apis.net.pe/v1/ruc?numero={$ruc}");
        }

        if ($response->successful()) {
            $result = $response->json();

            // Debug: Log the API response to see the actual structure
            \Log::info('SUNAT API Response for RUC ' . $ruc . ':', $result);

            // Handle different possible response structures
            $razonSocial = '';
            $direccion = '';

            // Try different possible keys for business name
            if (isset($result['razonSocial'])) {
                $razonSocial = $result['razonSocial'];
            } elseif (isset($result['razon_social'])) {
                $razonSocial = $result['razon_social'];
            } elseif (isset($result['nombre'])) {
                $razonSocial = $result['nombre'];
            } elseif (isset($result['nombreComercial'])) {
                $razonSocial = $result['nombreComercial'];
            } elseif (isset($result['success']) && $result['success'] && isset($result['data'])) {
                // Handle nested data structure
                $data = $result['data'];
                $razonSocial = $data['razonSocial'] ?? $data['razon_social'] ?? $data['nombre'] ?? '';
                $direccion = $data['direccion'] ?? $data['domicilio'] ?? '';
                return [
                    'razon_social' => $razonSocial,
                    'direccion'    => $direccion
                ];
            }

            // Try different possible keys for address
            if (isset($result['direccion'])) {
                $direccion = $result['direccion'];
            } elseif (isset($result['domicilio'])) {
                $direccion = $result['domicilio'];
            } elseif (isset($result['direccionFiscal'])) {
                $direccion = $result['direccionFiscal'];
            }

            return [
                'razon_social' => $razonSocial,
                'direccion'    => $direccion
            ];
        }

        \Log::error('SUNAT API call failed for RUC ' . $ruc . ': ' . $response->status() . ' - ' . $response->body());
        return [];
    }
}