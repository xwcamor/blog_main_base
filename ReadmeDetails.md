# 🚀 Laravel SaaS Base – Modular y Escalable

Este proyecto es una base profesional para construir aplicaciones **SaaS modernas y modulares** con Laravel.  
Incluye gestión de usuarios, roles y permisos, soporte multi-idioma, multi-país y multi-empresa, generación de documentos, exportación de datos, y funcionalidades avanzadas como firmas digitales y uso de IA.

---

## 🎯 Objetivos

- ✅ Autenticación y gestión de usuarios
- ✅ Gestión de roles y permisos (con base de datos)
- ✅ Soporte multi-empresa, multi-país, multi-idioma
- ✅ CRUD de módulos principales
- ✅ Panel administrativo moderno con [Filament](https://filamentphp.com/)
- ✅ Exportación e importación de datos (Excel, PDF, Word)
- ✅ Integración con IA
- ✅ Firma digital con canvas
- ✅ Estructura de carpetas limpia y escalable

---

## 📁 Estructura del Proyecto

```bash
app/
├── Http/
│   ├── Controllers/
│   │   └── SettingManagement/CompanyController.php
│   └── Requests/
│       └── SettingManagement/Company/
│           ├── CompanyStoreRequest.php
│           └── CompanyUpdateRequest.php

resources/
└── views/
    └── setting_management/companies/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php
```

> 🧠 Este patrón modular se replica para cada módulo (`UserManagement`, `AuthManagement`, `ReportManagement`, etc.)

---

## 🧰 Paquetes / Librerías Utilizadas

| Funcionalidad                     | Paquete Laravel                          |
|----------------------------------|------------------------------------------|
| Roles y permisos                 | `spatie/laravel-permission`              |
| Panel de administración          | `filament/filament`                      |
| Exportar a Excel                 | `maatwebsite/excel`                      |
| Generar PDF                      | `barryvdh/laravel-dompdf`                |
| Exportar a Word                  | `phpspreadsheet/phpspreadsheet`          |
| Canvas para firmas               | HTML5 Canvas + JS + Backend Laravel      |
| IA (opcional)                    | `openai-php/laravel`                     |
| Pruebas y debugging              | `phpunit`, `laravel/pint`, `laravel/pail`|
| Validaciones y formularios       | `laravel/form-request` (custom)          |

---

## ⚙️ Instalación rápida

```bash
git clone https://github.com/tu-usuario/laravel-saas-base.git
cd laravel-saas-base

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
```

---

## 📦 Comandos útiles

```bash
# Instalar roles y permisos
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

# Instalar Filament
composer require filament/filament
php artisan filament:install

# Crear un nuevo seeder
php artisan make:seeder RolesAndPermissionsSeeder

# Ejecutar el seeder
php artisan db:seed --class=RolesAndPermissionsSeeder
```

---

## 🧠 Conceptos Clave

- **Roles y permisos**: asignados dinámicamente desde la base de datos, no en código duro.
- **Vista y acceso**: todo está protegido con `@can`, `hasRole`, y middlewares.
- **Sidebar dinámico**: solo se muestra lo que el usuario tiene permiso de ver.
- **Multi-idioma**: preparado para `es`, `en`, `pt` con archivos de idioma.

---

## ✍️ Autor

**Carlos Morales (Axl)**  
Laravel / Rails Fullstack Developer – SoftwareBU  
📍 Perú  

---

## ✅ Estado del Proyecto

🟢 En desarrollo activo  
📦 Plantilla base funcional  
🧱 Estructura modular profesional  
🔧 Ampliable por módulos en minutos

---

## 📝 Licencia

Este proyecto está licenciado bajo la Licencia MIT.

---
# Corregir error
Paso 1: Verificar si tienes zip habilitado
Ejecuta en consola:
php -m | findstr zip
Si no aparece, hay que habilitarlo.
Paso 2: Habilitar ext-zip en Laragon (Windows)
Abre tu archivo de configuración:
C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini
Busca la línea:
;extension=zip
y quítale el ; al inicio:
extension=zip
Guarda los cambios.
Reinicia Laragon o al menos el servicio de Apache/MySQL.