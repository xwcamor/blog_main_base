# 🚀 Base APP - Companies Module

## 📝 Descripción
Este módulo permite gestionar **Empresas (Companies)** dentro del sistema, siguiendo buenas prácticas de segmentación y organización de archivos.  
Incluye **autocompletado de datos mediante una API pública** para agilizar la creación de registros.

---

## ⚙️ Funcionalidades

### CRUD Completo de Companies
- Listado de todas las empresas con paginación y filtros por RUC o nombre.
- Creación de nuevas empresas ingresando su RUC.
- Edición de empresas existentes.
- Eliminación de registros con motivo de eliminación, respetando auditoría del sistema.

### Campos principales de la empresa
- ID automático
- RUC (único)
- Razón social (nombre)

### Autocompletado de datos mediante API
- Al ingresar el RUC, el sistema consulta automáticamente la API pública de **SUNAT** para rellenar la razón social.
- API utilizada: [https://apis.net.pe/consulta-ruc-php.html](https://apis.net.pe/consulta-ruc-php.html)
- Configurable desde el archivo `.env` para cambiar de proveedor sin modificar código.

---

## 🏗️ Organización y buenas prácticas
- Controlador centralizado (`CompanyController`) que maneja toda la lógica.
- Vistas y scripts separados en archivos **Blade independientes**.
- Scripts de interacción y validaciones en su propio archivo.
- Traducciones centralizadas para todos los textos.
- Integración en el menú de Ajustes, junto con **Workers**.
- Validaciones de formularios y mensajes de éxito/advertencia visibles.

---

## 👨‍💻 Experiencia de usuario
- Autocompletado de razón social al ingresar el RUC.
- Confirmaciones al eliminar registros.
- Mensajes de éxito al crear, actualizar o eliminar empresas.
- Filtros y búsquedas por RUC o nombre.

---

## 🔄 Flujo de uso
1. Ingresar a **Ajustes → Companies** en el menú lateral.
2. Crear una nueva empresa ingresando su RUC.
3. Autocompletar la razón social mediante la API.
4. Guardar el registro.
5. Editar, eliminar o consultar detalles según sea necesario.

---

## 📁 Estructura de vistas Blade

- `resources/views/setting_management/companies/index.blade.php`  
- `resources/views/setting_management/companies/create.blade.php`  
- `resources/views/setting_management/companies/edit.blade.php`  
- `resources/views/setting_management/companies/show.blade.php`  

### Partials
- `resources/views/setting_management/companies/partials/table.blade.php`  
- `resources/views/setting_management/companies/partials/filters.blade.php`  
- `resources/views/setting_management/companies/partials/scripts.blade.php`  

---

## ⚙️ Configuración de la API
El módulo utiliza una API pública para autocompletar la razón social al ingresar el RUC.

### 📝 Pasos
1. Abrir el archivo `.env` en la raíz del proyecto Laravel.
2. Agregar la línea con tu token de la API:

```env
API_PERU_TOKEN=TU_TOKEN_AQUI
