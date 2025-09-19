# Laravel Project - Base App

This project is a base application in Laravel with functional authentication.
It includes a custom command to create the database, run migrations, and insert an initial user automatically.

---

## Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 
- Laravel 12.x
- Node.js (optional, for asset compilation)
- An environment such as Laragon  

---

## Initial Setup

1. Clone the repository:

```bash
git clone <url-del-repo>
cd project-name
```

2. Install dependencies:

```bash
composer install
```

3. Verify the file `.env`.  
   Make sure the database connection is configured correctly:

```
APP_NAME=AppBase
DB_DATABASE=blog_db
DB_USERNAME=root
DB_PASSWORD=
```

If this is a new project, change `DB_DATABASE` to the appropriate name (e.g., `app_new_db`).

4. Generate the application key:

```bash
php artisan key:generate
```

5. Clear temporary cache and old configurations:

```bash
php artisan optimize:clear
# php artisan permission:cache-reset  #Cache for permissions
```

---

## Initialize the Project

Run the custom command:

```bash
php artisan setup:project
```

This command will perform the following actions:
1. Drop the current database (if it exists).
2. Recreate the database.
3. Run all migrations.
4. Insert an initial user

---
## Run the Server

```bash
php artisan serve
```

Open in the browser:
http://127.0.0.1:8000

Other way to open on browser using laragon
http://name-folder.test

---

## Access the System

- Email:    `pingo@gmail.com`  
- Password: `123456`
