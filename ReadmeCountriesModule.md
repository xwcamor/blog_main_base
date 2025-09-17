# Readme: Módulo de Países

módulo de gestión de países (`setting_management/countries`).

---

## 1. Funcionalidad de Exportación (Excel y PDF)

Se añadieron botones en la página de índice de países para exportar los datos a formato Excel y PDF.

- **Comportamiento**: La exportación respeta los filtros que se hayan aplicado en la búsqueda. Si filtras por países activos, solo esos se exportarán.
- **Implementación**: Para mantener el código limpio y organizado, la lógica de exportación se ha separado en clases específicas:
  - **Excel**: La lógica reside en la clase `app/Exports/CountriesExcelExport.php`.
  - **PDF**: La lógica reside en la clase `app/Exports/CountriesPdfExport.php`. La plantilla visual del PDF es la vista `resources/views/setting_management/countries/pdf.blade.php`.
- **Dependencias**: Para habilitar esta función, se instalaron las siguientes librerías de Composer:
  ```bash
  composer require barryvdh/laravel-dompdf
  composer require maatwebsite/excel
  ```

---

## 2. Edición Masiva en Vivo (Live Inline Editing)

Se implementó una página para la edición masiva y en tiempo real de todos los países.

- **Acceso**: Se accede a través del botón **"Editar Todo"** en la página de índice de países.
- **Funcionalidad**: En la tabla, puedes hacer clic directamente sobre el nombre o el estado de un país para editarlo. El cambio se guarda automáticamente en la base de datos sin necesidad de un botón "Guardar".
- **Implementación**:
  - La vista principal es `resources/views/setting_management/countries/live_edit.blade.php`.
  - El comportamiento de auto-guardado está manejado por el script `public/adminlte/js/custom_live_edit.js`.
  - Las peticiones de actualización se procesan en el método `updateInline` del `CountryController`.

---

## 3. Internacionalización (Idiomas)

Todos los textos nuevos introducidos en la interfaz de usuario (etiquetas de botones, cabeceras de tabla, etc.) se implementaron utilizando el sistema de localización de Laravel.

- **Implementación**: Se añadieron nuevas claves de traducción en los siguientes archivos:
  - `resources/lang/en/global.php` (para inglés)
  - `resources/lang/es/global.php` (para español)
- **Ejemplo de Claves Añadidas**: `id`, `name`, `status`, `editable`.
