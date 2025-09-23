<?php

namespace App\Http\Controllers\SystemManagement;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\SystemManagement\Locales\StoreRequest;
use App\Http\Requests\SystemManagement\Locales\UpdateRequest;
use App\Http\Requests\SystemManagement\Locales\DeleteRequest;

// Model & Service
use App\Models\Locale;
use App\Services\SystemManagement\LocaleService;

// Illuminate
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    protected $service;

    public function __construct(LocaleService $service)
    {
        $this->service = $service;
    }

    /**
     * Listado con filtros y paginación.
     */
    public function index(Request $request)
    {
        // N+1 FIX: usamos eager loading para precargar la relación 'language'
        // de esta forma, al renderizar en la vista $locale->language->name
        // evitamos que se dispare una consulta por cada registro.
        $query = Locale::with('language');

        // Filtro simple por nombre
        if ($request->filled('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        $locales = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->all());

        return view('system_management.locales.index', compact('locales'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('system_management.locales.create');
    }

    /**
     * Guardar nuevo registro.
     */
    public function store(StoreRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('system_management.locales.index')
            ->with('success', __('locales.created_success'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Locale $locale)
    {
        return view('system_management.locales.edit', compact('locale'));
    }

    /**
     * Actualizar un registro.
     */
    public function update(UpdateRequest $request, Locale $locale)
    {
        $this->service->update($locale, $request->validated());

        return redirect()
            ->route('system_management.locales.index')
            ->with('success', __('locales.updated_success'));
    }

    /**
     * Vista de confirmación para eliminar.
     */
    public function delete(Locale $locale)
    {
        return view('system_management.locales.delete', compact('locale'));
    }

    /**
     * Guardar eliminación (soft delete).
     */
    public function deleteSave(DeleteRequest $request, Locale $locale)
    {
        $this->service->delete($locale, [
            'deleted_description' => $request->input('deleted_description'),
            'deleted_by' => auth()->id(),
        ]);

        return redirect()
            ->route('system_management.locales.index')
            ->with('success', __('locales.deleted_success'));
    }
}
