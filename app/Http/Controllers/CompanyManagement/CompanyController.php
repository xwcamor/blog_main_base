<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CompanyManagement\Company\StoreRequest;
use App\Http\Requests\CompanyManagement\Company\UpdateRequest;

class CompanyController extends Controller
{
    /**
     * Lista de empresas con filtros.
     */
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

        if ($request->filled('num_doc')) {
            $query->where('num_doc', 'like', '%' . $request->num_doc . '%');
        }

        $companies = $query->paginate(10)->appends($request->all());

        return view('company_management.companies.index', compact('companies'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('company_management.companies.create');
    }

    /**
     * Guarda una nueva empresa.
     */
    public function store(StoreRequest $request)
    {
        $data = $this->fetchFromSunat($request->ruc);

        // Extraer DNI si es persona natural (RUC inicia con 10)
        if (str_starts_with($request->ruc, '10')) {
            $data['num_doc'] = substr($request->ruc, 2, 8);
        }

        $numDoc = $request->filled('num_doc') ? $request->num_doc : ($data['num_doc'] ?? 'NO ENCONTRADO');

        Company::create([
            'ruc'          => $request->ruc,
            'razon_social' => $data['razon_social'] ?? '',
            'direccion'    => $data['direccion'] ?? '',
            'num_doc'      => $numDoc,
        ]);

        return redirect()->route('company_management.companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Company $company)
    {
        return view('company_management.companies.edit', compact('company'));
    }

    /**
     * Detalles de empresa.
     */
    public function show(Company $company)
    {
        return view('company_management.companies.show', compact('company'));
    }

    /**
     * Actualiza una empresa existente.
     */
    public function update(UpdateRequest $request, Company $company)
    {
        $numDoc = $request->num_doc;

        if (empty($numDoc) && str_starts_with($request->ruc, '10')) {
            $numDoc = substr($request->ruc, 2, 8);
        }

        $company->update([
            'ruc'          => $request->ruc,
            'razon_social' => $request->razon_social,
            'direccion'    => $request->direccion,
            'num_doc'      => $numDoc,
        ]);

        return redirect()->route('company_management.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Formulario de confirmación de eliminación.
     */
    public function delete(Company $company)
    {
        return view('company_management.companies.delete', compact('company'));
    }

    /**
     * Procesa la eliminación.
     */
    public function deleteSave(Request $request, Company $company)
    {
        $company->delete();

        return redirect()->route('company_management.companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    // Export Excel (background download)
    public function exportExcel(Request $request)
    {
        \App\Jobs\CompanyManagement\Companies\GenerateCompaniesExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    // Export PDF (background download)
    public function exportPdf(Request $request)
    {
        \App\Jobs\CompanyManagement\Companies\GenerateCompaniesPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    // Export Word (background download)
    public function exportWord(Request $request)
    {
        \App\Jobs\CompanyManagement\Companies\GenerateCompaniesWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    // =========================================================================
    // AJAX / API SUNAT
    // =========================================================================

    /**
     * Consulta RUC a SUNAT vía AJAX.
     */
    public function fetchRuc($ruc)
    {
        if (!preg_match('/^\d{11}$/', $ruc)) {
            return response()->json(['error' => 'RUC inválido'], 400);
        }

        $data = $this->fetchFromSunat($ruc);

        if (str_starts_with($ruc, '10')) {
            $data['num_doc'] = substr($ruc, 2, 8);
        } elseif (empty($data['num_doc'])) {
            $data['num_doc'] = 'NO ENCONTRADO';
        }

        return response()->json($data);
    }

    /**
     * Llama a la API externa de SUNAT.
     */
    private function fetchFromSunat($ruc)
    {
        $token = env('API_PERU_TOKEN');

        $response = Http::withToken($token)
            ->get("https://api.apis.net.pe/v2/sunat/ruc?numero={$ruc}");

        if (!$response->successful()) {
            $response = Http::withToken($token)
                ->get("https://api.apis.net.pe/v1/ruc?numero={$ruc}");
        }

        if ($response->successful()) {
            $result = $response->json();

            \Log::info('SUNAT API Response for RUC ' . $ruc . ':', $result);

            $razonSocial = '';
            $direccion = '';
            $numDoc = null;

            if (isset($result['razonSocial'])) {
                $razonSocial = $result['razonSocial'];
            } elseif (isset($result['razon_social'])) {
                $razonSocial = $result['razon_social'];
            } elseif (isset($result['nombre'])) {
                $razonSocial = $result['nombre'];
            } elseif (isset($result['nombreComercial'])) {
                $razonSocial = $result['nombreComercial'];
            } elseif (isset($result['success']) && $result['success'] && isset($result['data'])) {
                $data = $result['data'];
                $razonSocial = $data['razonSocial'] ?? $data['razon_social'] ?? $data['nombre'] ?? '';
                $direccion = $data['direccion'] ?? $data['domicilio'] ?? '';
                $numDoc = $data['num_doc'] ?? $data['numDoc'] ?? null;

                return [
                    'razon_social' => $razonSocial,
                    'direccion'    => $direccion,
                    'num_doc'      => $numDoc ?? 'NO ENCONTRADO',
                ];
            }

            if (isset($result['direccion'])) {
                $direccion = $result['direccion'];
            } elseif (isset($result['domicilio'])) {
                $direccion = $result['domicilio'];
            } elseif (isset($result['direccionFiscal'])) {
                $direccion = $result['direccionFiscal'];
            }

            if (isset($result['num_doc'])) {
                $numDoc = $result['num_doc'];
            } elseif (isset($result['numDoc'])) {
                $numDoc = $result['numDoc'];
            }

            return [
                'razon_social' => $razonSocial,
                'direccion'    => $direccion,
                'num_doc'      => $numDoc ?? 'NO ENCONTRADO',
            ];
        }

        \Log::error('SUNAT API call failed for RUC ' . $ruc . ': ' . $response->status() . ' - ' . $response->body());

        return [
            'razon_social' => '',
            'direccion'    => '',
            'num_doc'      => 'NO ENCONTRADO',
        ];
    }
}

