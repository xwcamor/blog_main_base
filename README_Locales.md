# Locales: Guía de implementación y buenas prácticas

Esta guía documenta los cambios realizados para el módulo de Locales y cómo replicarlos en otro proyecto similar (Laravel + Blade + AdminLTE). Está escrita para que cualquier persona, incluso con poca experiencia, pueda seguirla paso a paso.

La guía cubre:
- Estructura de rutas y controlador.
- Requests (validación) con namespaces correctos.
- Servicio de Locales con generación automática de `slug`.
- Vistas (index/create/edit/delete) con UI consistente a `system_modules`.
- Confirmación de borrado con SweetAlert.
- Prevención del problema N+1 (eager loading) al mostrar relaciones.

---

## 1) Rutas

Archivo: `routes/system_management.php`

- Las rutas de Locales están dentro de un grupo con prefijo y nombre de grupo:
```php
Route::prefix('system_management')->name('system_management.')->group(function () {
    Route::resource('locales', LocaleController::class)->names('locales');
    Route::get('locales/{locale}/delete', [LocaleController::class, 'delete'])->name('locales.delete');
    Route::delete('locales/{locale}/deleteSave', [LocaleController::class, 'deleteSave'])->name('locales.deleteSave');
});
```
- Nota: al usar `name('system_management.')` en el grupo y `->names('locales')` en el resource, los nombres finales quedan como `system_management.locales.*`.

---

## 2) Controlador

Archivo: `app/Http/Controllers/SystemManagement/LocaleController.php`

- Listado con filtros, paginación y Eager Loading para evitar N+1:
```php
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
```

- Eliminar (soft delete) pasando un array al servicio (evita error de tipo):
```php
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
```

---

## 3) Requests (validación)

Carpeta: `app/Http/Requests/SystemManagement/Locales/`

Asegúrate de que los namespaces coincidan con su ubicación (evita colisiones de clases):
- `StoreRequest.php`
- `UpdateRequest.php`
- `DeleteRequest.php`

Ejemplo (StoreRequest):
```php
<?php

namespace App\Http\Requests\SystemManagement\Locales;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // 'slug' ahora es opcional; se generará automáticamente
            'slug' => 'sometimes|nullable|string|max:22|unique:locales,slug',
            'code' => 'required|string|max:10', // ej: es_PE
            'name' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'is_active' => 'boolean',
        ];
    }
}
```

Importante: los archivos deben usar `namespace App\Http\Requests\SystemManagement\Locales;`.

---

## 4) Servicio de Locales

Archivo: `app/Services/SystemManagement/LocaleService.php`

- Genera un `slug` aleatorio y único si no se envía desde el formulario.
- Usa `withTrashed()` para no colisionar con registros soft-deleted.

```php
use Illuminate\Support\Str;

public function create(array $data)
{
    // Generar slug si no viene en la request
    if (empty($data['slug'])) {
        $data['slug'] = $this->generateUniqueSlug();
    }

    return Locale::create($data);
}

protected function generateUniqueSlug(int $length = 12): string
{
    do {
        $slug = Str::lower(Str::random($length));
    } while (Locale::withTrashed()->where('slug', $slug)->exists());

    return $slug;
}
```

- Eliminación (soft delete) recibiendo un array con `deleted_description` y `deleted_by`:
```php
public function delete(Locale $locale, array $data = [])
{
    if (isset($data['deleted_by'])) {
        $locale->deleted_by = $data['deleted_by'];
    }
    if (isset($data['deleted_description'])) {
        $locale->deleted_description = $data['deleted_description'];
    }
    $locale->save();

    $locale->delete();
    return true;
}
```

---

## 5) Modelo

Archivo: `app/Models/Locale.php`

- Incluye `language_id` en `$fillable` y define la relación:
```php
protected $fillable = [
    'slug', 'code', 'name', 'language_id', 'is_active',
    'created_by', 'deleted_by', 'deleted_description',
];

public function language()
{
    return $this->belongsTo(Language::class);
}
```

---

## 6) Vistas y estilo (UI)

Carpeta: `resources/views/system_management/Locales/`

- `index.blade.php`:
  - Card de filtros con botón de colapso y footer con “Buscar” / “Limpiar”.
  - Card de resultados con botón “Crear” y colapso en el header.
  - Tabla en `div.table-responsive`.
  - Botones de acciones discretos (profesionales), como `system_modules`:
    ```html
    <div class="btn-group btn-group-sm" role="group">
      <a class="btn btn-light" href="{{ route('system_management.locales.edit', $locale) }}" title="{{ __('global.edit') }}">
        <i class="fas fa-pen"></i>
      </a>
      <a class="btn btn-light" href="{{ route('system_management.locales.delete', $locale) }}" title="{{ __('global.delete') }}">
        <i class="fas fa-trash"></i>
      </a>
    </div>
    ```
  - Columna Idioma sin N+1 (gracias al eager loading) y acceso seguro:
    ```blade
    <!-- Safe access por si algún registro no tiene language asociado -->
    <td>{{ optional($locale->language)->name }}</td>
    ```

- `create.blade.php` y `edit.blade.php`:
  - El formulario real está en los parciales y su `id` es `form-save`.
  - El envío se hace desde el footer de la vista padre con:
    ```html
    <button type="submit" form="form-save" class="btn btn-primary">...</button>
    ```

- `partials/form_create.blade.php` y `partials/form_edit.blade.php`:
  - Formularios con `id="form-save"` y `data-parsley-validate`.
  - Campos obligatorios: `name`, `code`, `language_id`.

- `delete.blade.php` y `partials/form_delete.blade.php`:
  - El parcial define el formulario `form-save` con `@method('DELETE')`.
  - El botón “Eliminar” en la vista padre ejecuta `confirmDelete()` (SweetAlert).

---

## 7) SweetAlert (confirmación de borrado)

Archivo: `resources/views/layouts/plugins/sweetalert2.blade.php`

- Debe estar incluido por tu layout principal (por ejemplo, `layouts/app.blade.php`).
- Proporciona la función global `confirmDelete()` que valida con Parsley y, si todo está ok, envía `#form-save`.

```js
function confirmDelete() {
  Swal.fire({
    title: "{{ __('global.are_you_sure') }}",
    text: "{{ __('global.warning_delete') }}",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: "{{ __('global.destroy') }}",
    cancelButtonText: "{{ __('global.cancel') }}"
  }).then((result) => {
    if (result.isConfirmed) {
      if ($('#form-save').parsley().validate()) {
        document.getElementById('form-save').submit();
      }
    }
  });
}
```

---

## 8) Prevención del N+1 (GUÍA)

- Problema: si en la vista recorres `@foreach($locales as $locale)` y llamas `{{ $locale->language->name }}` sin precargar la relación, Laravel hará una consulta por cada fila (N+1).
- Solución: en el controlador, usar `Locale::with('language')` antes de paginar o filtrar. Ejemplo:
```php
$query = Locale::with('language');
```
- En la vista, accede con seguridad por si falta la relación:
```blade
{{ optional($locale->language)->name }}
```
- Verificación rápida: activa el log de consultas o usa Laravel Debugbar y revisa que no se dispare una consulta por cada fila.

---

## 9) Errores comunes y cómo evitarlos

- "Cannot declare class ... UpdateRequest, because the name is already in use":
  - Causa: namespaces incorrectos en Requests.
  - Solución: asegúrate de que los archivos en `app/Http/Requests/SystemManagement/Locales` tengan `namespace App\Http\Requests\SystemManagement\Locales;`.

- "Argument #2 ($data) must be of type array" al eliminar:
  - Causa: el servicio `delete()` espera un array y se le pasó un string.
  - Solución: enviar un array desde el controlador (ver sección Controlador > deleteSave).

- Slug requerido al crear:
  - Hacer que `slug` sea opcional en `StoreRequest` y generarlo en el servicio.

---

## 10) Checklist para replicar en otro proyecto

1. Crear `Locale` model y migración con campos (`slug`, `code`, `name`, `language_id`, `is_active`, etc.) y `SoftDeletes`.
2. Añadir relación `language()` en el modelo y `fillable` completo.
3. Crear `LocaleService` con generación de `slug` y método `delete()` que reciba array.
4. Crear Requests en `App/Http/Requests/SystemManagement/Locales/` con namespaces correctos.
5. Definir rutas con grupo `name('system_management.')` y `->names('locales')`.
6. Implementar `LocaleController` con eager loading en `index()` y métodos `create/store/edit/update/delete/deleteSave`.
7. Crear vistas en `resources/views/system_management/locales/` clonando la estética de `system_modules`.
8. Incluir `layouts/plugins/sweetalert2.blade.php` en tu layout principal.
9. Probar crear, editar, eliminar y navegar el listado.

---

## 11) Traducciones

- Añadimos `locales.code` en `resources/lang/es/locales.php` y `resources/lang/en/locales.php`.

---

## 12) Sugerencias finales

- Si agregas filtros por idioma, recuerda mantener `with('language')` para no perder el eager loading.
- Para tablas grandes considera índices en columnas `language_id`, `slug`, `code`.
- Reutiliza los parciales y estilos para mantener consistencia (como en `system_modules`).

