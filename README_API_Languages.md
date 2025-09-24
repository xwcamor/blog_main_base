# API REST para Módulo Languages

## Pasos para Implementar y Probar

1. **Instalar Laravel Sanctum**:
   - Ejecutar `composer require laravel/sanctum`.
   - Publicar archivos: `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`.
   - Migrar: `php artisan migrate`.

2. **Configurar User Model**:
   - Agregar `use Laravel\Sanctum\HasApiTokens;` y `HasApiTokens` al trait.

3. **Crear Controller API**:
   - Crear `app/Http/Controllers/Api/LanguageApiController.php` con métodos index, store, show, update, destroy, deleteSave.
   - Usar Requests existentes (StoreRequest, UpdateRequest, DeleteRequest) para validaciones.
   - Devolver JSON con estructura {data, message, meta}.

4. **Crear Rutas API**:
   - Crear `routes/api.php` con rutas protegidas por `auth:sanctum`.
   - Agregar endpoint para login: `POST /api/login` que devuelve token.

5. **Agregar Método apiLogin en LoginController**:
   - Crear método que valida email/password, autentica y crea token con Sanctum.

6. **Instalar Postman**:
   - Descargar de postman.com y crear workspace.

7. **Probar API en Postman**:
   - Base URL: `http://127.0.0.1:8000/api`.
   - Login: POST /api/login con {"email": "pingo@gmail.com", "password": "123456"} → guardar token.
   - Listar: GET /api/languages con header Authorization: Bearer {token}.
   - Crear: POST /api/languages con body {"name": "Spanish", "iso_code": "es"}.
   - Verificar validaciones: Enviar sin name → error 422.
   - Actualizar/Eliminar: Usar PUT/DELETE con slug.

## Conocimientos Aprendidos

- **API REST**: Interfaz para comunicación entre sistemas, usa HTTP methods, stateless, devuelve JSON. Sirve para integrar apps externas sin UI.
- **Validaciones**: Requests en Laravel aseguran datos correctos; fallan con 422 y errores JSON.
- **Autenticación**: Sanctum crea tokens para APIs seguras.
- **Postman**: Herramienta para testing APIs, simula requests y verifica respuestas.
- **Jobs vs APIs**: Jobs para background (e.g., exports); APIs para acceso inmediato programático.