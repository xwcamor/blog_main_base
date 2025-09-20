# Guía Paso a Paso para Crear el Módulo Company

Este documento describe el proceso completo para implementar el módulo **Company** en una aplicación Laravel, incluyendo la integración con la API de SUNAT para autocompletar datos de empresas peruanas por RUC.

## Requisitos Previos

- Laravel 10+
- Base de datos configurada (MySQL/PostgreSQL)
- Token de API de SUNAT (apis.net.pe) configurado en `.env`
- AdminLTE para las vistas

## Paso 1: Crear la Migración de la Base de Datos

Ejecuta el comando Artisan para crear la migración:

```bash
php artisan make:migration create_companies_table
```

**Contenido del archivo `database/migrations/YYYY_MM_DD_HHMMSS_create_companies_table.php`:**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('ruc')->unique();
            $table->string('razon_social');
            $table->string('direccion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
```

Ejecuta la migración:

```bash
php artisan migrate
```

## Paso 2: Crear el Modelo Company

```bash
php artisan make:model Company
```

**Contenido del archivo `app/Models/Company.php`:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
    ];
}
```

## Paso 3: Crear las Clases de Validación (Form Requests)

### StoreRequest para creación:

```bash
php artisan make:request SystemManagement/Company/StoreRequest
```

**Contenido de `app/Http/Requests/SystemManagement/Company/StoreRequest.php`:**

```php
<?php

namespace App\Http\Requests\SystemManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ruc' => 'required|unique:companies,ruc|digits:11',
        ];
    }
}
```

### UpdateRequest para actualización:

```bash
php artisan make:request SystemManagement/Company/UpdateRequest
```

**Contenido de `app/Http/Requests/SystemManagement/Company/UpdateRequest.php`:**

```php
<?php

namespace App\Http\Requests\SystemManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'ruc' => 'required|digits:11|unique:companies,ruc,' . $this->company->id,
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ];
    }
}
```

## Paso 4: Crear el Controlador

```bash
php artisan make:controller SystemManagement/CompanyController
```

**Contenido del archivo `app/Http/Controllers/SystemManagement/CompanyController.php`:**

```php
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
        $token = env('API_PERU_TOKEN');

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

            \Log::info('SUNAT API Response for RUC ' . $ruc . ':', $result);

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
```

## Paso 5: Configurar las Rutas

Agrega las rutas en `routes/web.php` dentro del grupo de `system_management`:

```php
// Companies
Route::get('/companies/fetch-ruc/{ruc}', [CompanyController::class, 'fetchRuc'])->name('companies.fetchRuc');
Route::resource('companies', CompanyController::class)->names('companies');
Route::get('companies/{company}/delete',        [CompanyController::class, 'delete'])    ->name('companies.delete');
Route::delete('companies/{company}/deleteSave', [CompanyController::class, 'deleteSave'])->name('companies.deleteSave');
```

## Paso 6: Crear Archivos de Traducción

### Inglés (`resources/lang/en/companies.php`):

```php
<?php
return [
    'singular'        => 'Company',
    'plural'          => 'Companies',

    'index_title'     => 'Companies List',
    'create_title'    => 'Company - Create',
    'show_title'      => 'Company - Details',
    'edit_title'      => 'Edit Company',
    'delete_title'    => 'Delete Company',

    'id'              => 'No.',
    'ruc'             => 'RUC',
    'razon_social'    => 'Business Name',
    'direccion'       => 'Address',
    'is_active'       => 'Status',
    'created_at'     => 'Created At',
    'updated_at'     => 'Updated At',
];
```

### Español (`resources/lang/es/companies.php`):

```php
<?php

return [
    'singular'        => 'Empresa',
    'plural'          => 'Empresas',

    'index_title'     => 'Lista de Empresas',
    'create_title'    => 'Crear Empresa',
    'show_title'      => 'Detalles de la Empresa',
    'edit_title'      => 'Editar Empresa',
    'delete_title'    => 'Eliminar Empresa',

    'id'              => 'No.',
    'ruc'             => 'RUC',
    'razon_social'    => 'Razón Social',
    'direccion'       => 'Dirección',
    'is_active'       => 'Estado',
    'created_at'     => 'Creado en',
    'updated_at'     => 'Actualizado en',
];
```

## Paso 7: Crear las Vistas Blade

Crea la estructura de directorios:

```
resources/views/system_management/companies/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
├── show.blade.php
├── delete.blade.php
├── partials/
│   ├── filters.blade.php
│   ├── table.blade.php
│   └── scripts.blade.php
```

### Vista Index (`resources/views/system_management/companies/index.blade.php`):

```blade
@extends('layouts.app')

@section('title', __('companies.index_title'))

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
          <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @include('system_management.companies.partials.filters')
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom font-weight-bold">
            <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
            @if ($companies->total() > 0)<strong>{{ $companies->total() }}</strong>@else 0 @endif
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.card_collapse') }}">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-right pt-0 pb-1">
              <a class="btn btn-primary" href="{{ route('system_management.companies.create') }}">
                <i class="fas fa-plus"></i> {{ __('global.create') }}
              </a>
            </div>
          </div>
          <div class="table-responsive">
            @include('system_management.companies.partials.table')
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
```

## Paso 8: Configurar la API de SUNAT

Agrega el token de la API en tu archivo `.env`:

```env
API_PERU_TOKEN=tu_token_aqui
```

Obtén tu token en: https://apis.net.pe/

## Paso 9: Agregar al Menú de Navegación

Agrega el enlace al módulo en tu sidebar (`resources/views/layouts/sidebar_left.blade.php`):

```blade
<li class="nav-item">
  <a href="{{ route('system_management.companies.index') }}" class="nav-link">
    <i class="nav-icon fas fa-building"></i>
    <p>{{ __('companies.plural') }}</p>
  </a>
</li>
```

## Funcionalidades Implementadas

- ✅ CRUD completo (Crear, Leer, Actualizar, Eliminar)
- ✅ Validación de formularios
- ✅ Paginación
- ✅ Filtros de búsqueda
- ✅ Integración con API de SUNAT para autocompletar RUC
- ✅ Soporte multiidioma (Inglés/Español)
- ✅ Interfaz AdminLTE
- ✅ Manejo de errores y logs

## Notas Importantes

1. Asegúrate de tener configurado el middleware de autenticación
2. El RUC debe tener exactamente 11 dígitos
3. La API de SUNAT requiere un token válido
4. Las vistas usan AdminLTE para el diseño
5. El controlador incluye logging para debugging de la API

## Próximos Pasos

- Agregar exportación a Excel/PDF
- Implementar soft deletes
- Agregar campos adicionales según necesidades
- Crear tests unitarios
- Optimizar consultas con eager loading si es necesario