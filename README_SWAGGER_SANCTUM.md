Integración rápida: Sanctum + Swagger (Laravel)

Resumen

Este repositorio ya incluye "laravel/sanctum" en composer.json. A continuación tienes pasos concretos para:

- Asegurar endpoints API con Sanctum (token-based)
- Añadir documentación OpenAPI/Swagger usando L5-Swagger o swagger-php + swagger-ui

1) Sanctum (ya presente)

- Verifica que en `config/sanctum.php` y `config/auth.php` exista la configuración. Se añadió un guard `api` con driver `sanctum`.
- Migraciones: si no has ejecutado migraciones aún, corre:

PowerShell:

php artisan migrate

- Crear tokens (ejemplo ya implementado): el endpoint POST /api/login (en `routes/api.php`) llama a `App\Http\Controllers\AuthManagement\AuthController@login` y devuelve `access_token` (Sanctum Personal Access Token). El endpoint GET /api/me devuelve el usuario autenticado (usa middleware `auth:sanctum`).

2) Swagger / OpenAPI

Opción A — L5-Swagger (recomendado, integración completa):

1. Instalar con composer:

PowerShell:

composer require darkaonline/l5-swagger

2. Publicar config y assets:

php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

3. Generar documentación (usa anotaciones en tus controladores):

php artisan l5-swagger:generate

La UI quedará accesible típicamente en /api/documentation o según `config/l5-swagger.php`.

Nota: si encuentras problemas de compatibilidad con Laravel 12, en lugar de L5-Swagger puedes usar `zircote/swagger-php` + `swagger-ui-dist` manualmente.

Opción B — swagger-php + swagger-ui-dist (manual):

1. Instalar:

composer require zircote/swagger-php
npm install swagger-ui-dist --save-dev

2. Añadir anotaciones en tus controladores (ej.: `@OA\Get`, `@OA\Post`).
3. Generar JSON con `php artisan vendor:publish` o ejecutando `\OpenApi\Generator::scan([...])` desde un comando personalizado.
4. Servir `swagger-ui` y apuntar a tu swagger.json.

3) Ejemplos y seguridad

- El archivo `app/Http/Controllers/AuthManagement/AuthController.php` incluye ejemplos de anotaciones para `POST /api/login` y `GET /api/me` con seguridad `sanctum`.
- Para probar con Postman: crea una petición POST /api/login con JSON `{ "email": "user@example.com", "password": "secret" }`. Usa el `access_token` en el header `Authorization: Bearer <token>` para acceder a `/api/me`.

4) Pasos recomendados después de instalar L5-Swagger

- Ejecuta `php artisan l5-swagger:generate` después de instalar.
- Revisa `config/l5-swagger.php` para ajustar rutas y middleware (por ejemplo proteger la UI en non-local).
- Añade más anotaciones en controladores y modelos para describir respuestas y esquemas.

Contacto

Si quieres, puedo:
- Ejecutar cambios automáticos adicionales (rutas, controladores, ejemplo de comando para generar swagger.json)
- Añadir un comando artisan para generar el swagger.json si prefieres no instalar L5-Swagger
- Probar un flujo local con migraciones y generar docs (necesitaría que ejecutes composer/npm localmente)

