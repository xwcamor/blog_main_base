# Guía para Crear el Módulo de Gestión de Empresas (Companies)

Esta guía explica paso a paso cómo crear el módulo completo de gestión de empresas en un proyecto Laravel modular.

## 📁 Estructura General del Módulo

### 1. Arquitectura del Módulo
```
app/
├── Http/Controllers/CompanyManagement/
│   └── CompanyController.php
├── Http/Requests/CompanyManagement/Company/
│   ├── StoreRequest.php
│   └── UpdateRequest.php
└── Models/
    └── Company.php

resources/
├── views/company_management/companies/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   ├── delete.blade.php
│   └── partials/
│       ├── table.blade.php
│       ├── filters.blade.php
│       └── scripts.blade.php
└── lang/
    ├── en/companies.php
    └── es/companies.php

routes/
└── company_management.php

database/migrations/
└── create_companies_table.php
```

## 🗄️ Base de Datos

### 1. Crear Migración
- Ubicación: `database/migrations/`
- Nombre: `create_companies_table.php`
- Campos requeridos:
  - `ruc` (string, único, 11 caracteres)
  - `razon_social` (string, requerido)
  - `direccion` (string, requerido)
  - `num_doc` (string, opcional)
  - Timestamps automáticos

### 2. Modelo Eloquent
- Ubicación: `app/Models/Company.php`
- Campos fillable: ruc, razon_social, direccion, num_doc
- Sin relaciones adicionales inicialmente

## 🛣️ Sistema de Rutas

### 1. Archivo de Rutas Principal
- Ubicación: `routes/company_management.php`
- Prefijo: `company_management`
- Nombre base: `company_management.`
- Rutas RESTful completas para companies

### 2. Integración en Rutas Globales
- Archivo: `routes/web.php`
- Incluir el archivo company_management.php
- Proteger con middleware de autenticación

## 🎮 Controlador

### 1. CompanyController
- Ubicación: `app/Http/Controllers/CompanyManagement/CompanyController.php`
- Métodos CRUD completos:
  - `index()` - Lista con filtros y paginación
  - `create()` - Vista de creación
  - `store()` - Guardar nueva empresa
  - `show()` - Ver detalles
  - `edit()` - Vista de edición
  - `update()` - Actualizar empresa
  - `delete()` - Vista de confirmación
  - `deleteSave()` - Eliminar empresa
- Método adicional: `fetchRuc()` para autocompletado AJAX

### 2. Form Requests
- Ubicación: `app/Http/Requests/CompanyManagement/Company/`
- `StoreRequest.php` - Validaciones para creación
- `UpdateRequest.php` - Validaciones para actualización
- Campos validados: ruc, razon_social, direccion, num_doc

## 🎨 Vistas (Views)

### 1. Estructura de Vistas
Todas las vistas extienden `@extends('layouts.app')`

#### Vista Principal (`index.blade.php`)
- Título: Lista de empresas
- Secciones:
  - Filtros de búsqueda
  - Tabla de resultados con paginación
  - Botón de crear nueva empresa

#### Vista de Creación (`create.blade.php`)
- Título: Crear Empresa
- Formulario con campos:
  - RUC (con autocompletado)
  - Razón Social
  - Dirección
  - Número de Documento (opcional)

#### Vista de Edición (`edit.blade.php`)
- Similar a creación pero con datos existentes
- Método PUT en formulario

#### Vista de Detalles (`show.blade.php`)
- Mostrar información completa de la empresa
- Sin formulario de edición

#### Vista de Eliminación (`delete.blade.php`)
- Confirmación antes de eliminar
- Método DELETE

### 2. Vistas Parciales (`partials/`)

#### `table.blade.php`
- Tabla con columnas: ID, RUC, Razón Social, Dirección, Num Doc, Creado, Acciones
- Enlaces de ordenamiento por columna
- Acciones: Ver, Editar, Eliminar

#### `filters.blade.php`
- Formulario GET para filtros
- Campos: RUC, Razón Social, Dirección, Num Doc
- Botones: Buscar y Limpiar

#### `scripts.blade.php`
- JavaScript para autocompletado de RUC
- Llamada AJAX a API externa (SUNAT)
- Actualización automática de campos

## 🌐 Sistema de Idiomas

### 1. Archivos de Traducción
- `resources/lang/en/companies.php`
- `resources/lang/es/companies.php`

### 2. Claves de Traducción
- Títulos de páginas
- Etiquetas de campos
- Mensajes de validación
- Textos de acciones
- Encabezados de tabla

### 3. Integración en Sidebar
- Actualizar `resources/lang/*/sidebar.php`
- Añadir sección "Companies" en el menú lateral

## 🎛️ Sidebar (Menú Lateral)

### 1. Ubicación
- Archivo: `resources/views/layouts/partials/app_sidebar_left.blade.php`

### 2. Estructura del Menú
```html
<!-- COMPANIES -->
<li class="nav-header">Gestión de Empresas</li>
<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-building"></i>
    <p>Empresas <i class="fas fa-angle-left right"></i></p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('company_management.companies.index') }}"
         class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Lista de Empresas</p>
      </a>
    </li>
  </ul>
</li>
```

## 🔧 Funcionalidades Especiales

### 1. Autocompletado de RUC
- Campo RUC con evento keyup
- Consulta a API externa (SUNAT Perú)
- Autocompletado de razón social y dirección
- Extracción automática de DNI para personas naturales

### 2. Sistema de Filtros
- Búsqueda por múltiples campos
- Paginación de resultados
- Ordenamiento por columnas
- Mantener filtros en paginación

### 3. Validaciones
- RUC único en base de datos
- RUC válido (11 dígitos)
- Campos requeridos según reglas de negocio

## 📋 Checklist de Implementación

### Base de Datos
- [ ] Crear migración
- [ ] Ejecutar migración
- [ ] Verificar tabla creada

### Backend
- [ ] Crear modelo Company
- [ ] Crear CompanyController
- [ ] Crear Form Requests
- [ ] Configurar rutas
- [ ] Probar rutas con Artisan

### Frontend
- [ ] Crear estructura de vistas
- [ ] Implementar formularios
- [ ] Crear tabla con funcionalidades
- [ ] Implementar JavaScript
- [ ] Actualizar sidebar

### Idiomas
- [ ] Crear archivos de traducción
- [ ] Traducir todos los textos
- [ ] Actualizar sidebar translations

### Testing
- [ ] Crear empresa nueva
- [ ] Probar autocompletado RUC
- [ ] Editar empresa existente
- [ ] Eliminar empresa
- [ ] Probar filtros y búsqueda
- [ ] Verificar paginación
- [ ] Cambiar idioma y verificar traducciones

## 🚀 Próximos Pasos

Una vez implementado el módulo básico, se pueden añadir:

1. **Exportación de datos** (Excel, PDF)
2. **Importación masiva** desde Excel
3. **Historial de cambios** (auditoría)
4. **Relaciones con otras entidades** (usuarios, tenants)
5. **Permisos específicos** por empresa
6. **API REST** para integración externa

## 📚 Referencias

- [Documentación Laravel - Controladores](https://laravel.com/docs/controllers)
- [Documentación Laravel - Eloquent](https://laravel.com/docs/eloquent)
- [Documentación Laravel - Validación](https://laravel.com/docs/validation)
- [Documentación Laravel - Localización](https://laravel.com/docs/localization)

---

**Nota**: Esta guía asume un proyecto Laravel con AdminLTE y estructura modular ya configurada.