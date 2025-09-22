# 🧱 Modular Structure in Laravel (Professional Recommendation)

This document defines the recommended structure to organize your Laravel application in a **modular** and **scalable** way, following modern best practices and naming conventions.

---

## 🌐 Global Vision

Your application should be structured by **modules (domains)**.  
Each module groups its **controllers, requests, services, views, exports, and templates**.  
This ensures **separation of concerns**, maintainability, and scalability.

```plaintext
app/                                # Core application code
├── Http/                           # HTTP layer (controllers, requests, middleware)
│   ├── Controllers/                # Controllers grouped by module
│   └── Requests/                   # FormRequests (validation per action)
│
├── Models/                         # Eloquent models
├── Services/                       # Business logic per module
├── Exports/                        # Excel/CSV/Word export classes
├── Imports/                        # Excel/CSV import classes
│
resources/                          # Frontend assets and templates
├── views/                          # Blade templates (per module/entity)
│   └── {module}/{entity}/pdf/      # Blade templates for PDFs
├── templates/                      # Word templates (.docx)
└── lang/                           # Multi-language translations (en, es, pt, …)
│
storage/                            # Dynamically generated files
├── app/
│   ├── pdfs/                       # Generated PDFs
│   ├── exports/                    # Generated Excel/CSV files
│   └── imports/                    # Uploaded Excel/CSV files
│
routes/                             # Application routes
├── web.php                         # Web routes (modules, controllers, views)
├── api.php                         # API routes
└── console.php                     # Artisan console commands
```

---

## 📁 Controller Layer

- Located in: `app/Http/Controllers/{Module}`  
- Handles HTTP requests and delegates **business logic** to Services.  
- Uses **Form Requests** for validation.  
- Returns **views** or **API responses**.  

✅ Controllers must remain **thin**. No heavy business logic.

---

## 📁 Request Layer (Validation)

- Located in: `app/Http/Requests/{Module}/{Entity}`  
- Each action has its own request (`Store`, `Update`, `Delete`).  
- Ensures all inputs are validated before reaching the Controller.  

✅ Keeps **validation separate from business logic**.

---

## 📁 Service Layer (Business Logic)

- Located in: `app/Services/{Module}`  
- Encapsulates **domain logic** (create, update, delete).  
- Called by Controllers, interacts with Models.  

✅ Services make controllers reusable and testable.

---

## 📁 Model Layer (Database ORM)

- Located in: `app/Models/`  
- Defines database structure and relationships.  
- Used by Services to persist and retrieve data.

---

## 📁 View Layer (Presentation)

- Located in: `resources/views/{module}/{entity}`  
- Uses **lowercase plural folders** (`companies`, `users`, `countries`).  
- Contains `index`, `create`, `edit`, `show`, plus `partials` and `pdf`.  

✅ Views should rely on **translations** (`lang/`) instead of hardcoded text.

---

## 📁 Word, Excel, CSV and PDF Structure

### 📝 Word Templates
- Location:  

```plaintext
resources/templates/{module}/{entity}/template.docx
```

- Purpose: Word templates are static **source files** with placeholders.  
- They belong under `resources/` because they are **versionable assets**.

---

### 📊 Excel & CSV
- Classes for export/import:  

```plaintext
app/Exports/{Module}/{Entity}Export.php
app/Imports/{Module}/{Entity}Import.php
```

- Generated files:  

```plaintext
storage/app/exports/   # Exported Excel/CSV files
storage/app/imports/   # Uploaded Excel/CSV files
```

- Purpose: Business logic for Excel/CSV belongs in `app/Exports` and `app/Imports`.  
- Generated files go into `storage/` (never versioned).  

---

### 📄 PDF
- Templates:  

```plaintext
resources/views/{module}/{entity}/pdf/template.blade.php
```

- Generated files:  

```plaintext
storage/app/pdfs/
```

- Purpose: Blade templates define PDF structure, while actual generated files are stored in `storage/`.

---

### 📌 Best Practices
- **resources/** → templates that should be versioned (Blade, DOCX).  
- **app/Exports, app/Imports/** → logic classes for handling data.  
- **storage/** → dynamically generated files (PDF, Excel, CSV).  
- **public/** → only for assets that must be publicly accessible (logos, images).  

---

## 📁 Routes Structure

### 1. Root routes file (`routes/web.php`)

Your **root route file** centralizes all modules.  

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardManagement\DashboardController;
use App\Http\Controllers\SettingManagement\CompanyController;
use App\Http\Controllers\UserManagement\UserController;

// Dashboard (default home)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Setting Management
Route::prefix('setting-management')->name('setting_management.')->group(function () {
    Route::resource('companies', CompanyController::class);
});

// User Management
Route::prefix('user-management')->name('user_management.')->group(function () {
    Route::resource('users', UserController::class);
});
```

---

### 2. Example Generated Routes

| HTTP Method | URI                                       | Route Name                              | Action   |
|-------------|-------------------------------------------|------------------------------------------|----------|
| GET         | `/setting-management/companies`           | `setting_management.companies.index`     | index    |
| GET         | `/setting-management/companies/create`    | `setting_management.companies.create`    | create   |
| POST        | `/setting-management/companies`           | `setting_management.companies.store`     | store    |
| GET         | `/setting-management/companies/{id}`      | `setting_management.companies.show`      | show     |
| GET         | `/setting-management/companies/{id}/edit` | `setting_management.companies.edit`      | edit     |
| PUT/PATCH   | `/setting-management/companies/{id}`      | `setting_management.companies.update`    | update   |
| DELETE      | `/setting-management/companies/{id}`      | `setting_management.companies.destroy`   | destroy  |

---

## 🔗 How Layers Interact (Flow Example)

1. **User** submits a form →  
2. **Form Request** validates data →  
3. **Controller** receives validated data →  
4. **Controller** calls a **Service** →  
5. **Service** interacts with **Model** (DB) →  
6. **Controller** returns **View** (Blade or Export) →  
7. **Translations** ensure multi-language support.

---

## 🚀 Adding a New Module (Step by Step)

1. Create Controller under `app/Http/Controllers/{Module}`  
2. Create Form Requests under `app/Http/Requests/{Module}/{Entity}`  
3. Create Service under `app/Services/{Module}/{Entity}Service.php`  
4. Create Model in `app/Models/{Entity}.php`  
5. Create Views in `resources/views/{module}/{entity}`  
6. Add routes in `routes/web.php` with `Route::prefix()` and `Route::resource()`  
7. Add translations in `/resources/lang/{locale}/global.php`  

---

## 📌 Best Practices

- **Controllers → thin**, **Services → fat**  
- One **Request per action**  
- Always use **translation helpers**  
- Keep **exports/templates** outside the core app  
- Run `composer dump-autoload -o` after adding new folders/namespaces  

---

## 📂 Example Root Tree (with comments)

```plaintext
app/                                 # Application core code
└── Http/                            # HTTP layer
    └── Controllers/                  # Controllers (per module)
        └── SettingManagement/        # Example module: Setting Management
            └── CompanyController.php # Handles company CRUD
            └── OtherController.php   # Another controller in the module            
    └── Models/                       # Database models
        └── Company.php               # Eloquent model for companies            
    └── Requests/                     # FormRequest validations
        └── SettingManagement/        # Requests for Setting Management module
            └── Company/              # Entity: Company
                ├── CompanyStoreRequest.php   # Validation for creating
                ├── CompanyUpdateRequest.php  # Validation for updating
                └── CompanyDeleteRequest.php  # Validation for deleting        
└── Services/                         # Business logic per module
    └── SettingManagement/            
        └── CompanyService.php        # Service with CRUD methods for Company
        └── OtherService.php          # Example of another service      
└── Exports/                          # Excel/CSV/Word export classes
└── Imports/                          # Excel/CSV import classes

resources/                            # Views and templates
└── views/                            # Blade templates
    └── setting_management/           
        └── companies/                # Views for Company entity
            ├── index.blade.php       # List view
            ├── create.blade.php      # Form to create
            ├── edit.blade.php        # Form to edit
            └── show.blade.php        # Detail view
    └── {module}/{entity}/pdf/        # Blade templates for PDF
└── templates/                        # Word templates (docx)
    └── {module}/{entity}/            # Organized by module/entity
└── lang/                             # Multi-language translations
    └── en/           
        └── global.php                # Global translation strings     

storage/                              # Generated dynamic files
└── app/
    ├── pdfs/                         # Generated PDFs
    ├── exports/                      # Generated Excel/CSV files
    └── imports/                      # Uploaded Excel/CSV files

routes/                               # Route definitions
└── web.php                           # Root route file (loads all module routes)
```

---

©️ **Team Software** – Clean Modular Architecture for Laravel 🚀
