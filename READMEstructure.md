# 🧱 Modular Structure in Laravel (Professional Recommendation)

This document defines the recommended structure to organize your Laravel application in a **modular** and **scalable** way, following modern best practices and naming conventions.

---

## 📁 Controller Structure

Controllers should be grouped by **domain (module)**. Each module has its own folder under `app/Http/Controllers/`.

```plaintext
app/
└── Http/
    └── Controllers/
        └── SettingManagement/
            └── CompanyController.php
```

---

## 📁 Form Request Structure

Form Requests should be grouped by module and entity. Use one file **per action** (`store`, `update`, `delete`) following the pattern: `<Entity><Action>Request.php`.

```plaintext
app/
└── Http/
    └── Requests/
        └── SettingManagement/
            └── Company/
                ├── CompanyStoreRequest.php
                ├── CompanyUpdateRequest.php
                └── CompanyDeleteRequest.php
```

> ✅ This structure respects **Single Responsibility Principle (SRP)** and allows each request class to handle validation for a single action.

---

## 📁 Blade Views Structure

Blade views should be organized in folders by module and entity. Use **lowercase** and **plural** folder names (common Laravel RESTful convention).

```plaintext
resources/
└── views/
    └── setting_management/
        └── companies/
            ├── index.blade.php
            ├── create.blade.php
            ├── edit.blade.php
            └── show.blade.php
```

> 💡 Use `snake_case` or `kebab-case` for folder names with multiple words if needed.

---

## 🔀 Route Structure with Module Prefix

Use `Route::prefix()` and `Route::name()` to group routes by module and keep them clean and maintainable.

```php
use App\Http\Controllers\SettingManagement\CompanyController;

Route::prefix('setting-management')->name('setting_management.')->group(function () {
    Route::resource('companies', CompanyController::class);
});
```

This will generate route names like:

| HTTP Method | URI                                         | Route Name                              | Action   |
|-------------|---------------------------------------------|------------------------------------------|----------|
| GET         | `/setting-management/companies`             | `setting_management.companies.index`     | index    |
| GET         | `/setting-management/companies/create`      | `setting_management.companies.create`    | create   |
| POST        | `/setting-management/companies`             | `setting_management.companies.store`     | store    |
| GET         | `/setting-management/companies/{id}`        | `setting_management.companies.show`      | show     |
| GET         | `/setting-management/companies/{id}/edit`   | `setting_management.companies.edit`      | edit     |
| PUT/PATCH   | `/setting-management/companies/{id}`        | `setting_management.companies.update`    | update   |
| DELETE      | `/setting-management/companies/{id}`        | `setting_management.companies.destroy`   | destroy  |

---

## 📁 Translation File Structure

Place your language files here:

```
/resources/lang/
  ├── en/global.php
  ├── es/global.php
  └── pt/global.php
```
---

## 🧩 Using Translations in Views

To display translated text, use the `__()` helper in your Blade templates:

```blade
{{ __('global.app_name') }}
{{ __('global.clear') }}
```
---

## 📁 Pdf Structure

Place your language files here:
PDF → resources/views/

```
/resources/views/
  ├── {module}/{entity}/pdf/template.blade.php
```

---

## 📁 Word Structure
Word → resources/templates/{module}/{entity}/template.docx

---

## 📁 Excel Structure
Excel → no template (export on app/Exports/…).

---

## 📌 Final Notes

- Use **PascalCase** for class names (e.g., `CompanyController`, `CompanyStoreRequest`)
- Use **lowercase plural** for view folders (e.g., `companies`)
- Group everything by module to ensure separation of concerns and maintainability
- This structure is ideal for medium and large Laravel projects with multiple domains/modules

---


## Extra Knowledge
Add default fk association
$table->foreignId('region_id')->constrained();

Add specific fk association
$table->foreignId('default_locale_id')->constrained('locales'); 

Display all data
Model::create($request->all());

Tenant URL configuration:
- Edit file C:\laragon\etc\apache2\sites-enabled\00-default.conf

<VirtualHost *:80>
    DocumentRoot "C:/laragon/www/blog/public"
    ServerName blog.test
    ServerAlias *.blog.test
    <Directory "C:/laragon/www/blog/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

- Find the  file C:\Windows\System32\drivers\etc\hosts and open it

- Add the following  'hitachi = the on first tenant example' , 'blog=folder-name'
127.0.0.1      hitachi.blog.test

©️ **Team Software** – Clean Modular Architecture for Laravel 🚀