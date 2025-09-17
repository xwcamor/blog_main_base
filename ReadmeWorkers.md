# 🚀 Base APP - Workers Module

## 📝 Descripción
Este módulo permite gestionar **Trabajadores (Workers)** dentro del sistema, siguiendo buenas prácticas de segmentación y organización de archivos.  
Incluye **autocompletado de datos mediante una API pública** para agilizar la creación de registros.

---

## ⚙️ Funcionalidades

### CRUD Completo de Trabajadores
- 📄 Listado de todos los trabajadores con paginación y filtros por documento, nombre o apellido.
- ➕ Creación de nuevos trabajadores ingresando su DNI.
- ✏️ Edición de trabajadores existentes.
- 🗑️ Eliminación de registros con motivo de eliminación, respetando auditoría del sistema.

### Campos principales del trabajador
- ID automático
- Documento de identidad (DNI)
- Nombre
- Apellido

### Autocompletado de datos mediante API
- Al ingresar el DNI, el sistema consulta automáticamente la API pública de **RENIEC/SUNAT** para rellenar nombre y apellido.
- API utilizada: [https://apis.net.pe/consulta-ruc-php.html](https://apis.net.pe/consulta-ruc-php.html)
- Configurable desde el archivo `.env` para cambiar de proveedor sin modificar código.

---

## 🏗️ Organización y buenas prácticas
- Controlador centralizado (`WorkerController`) que maneja toda la lógica.
- Vistas y scripts separados en archivos **Blade independientes**.
- Scripts de interacción y validaciones en su propio archivo.
- Traducciones centralizadas para todos los textos.
- Integración en el menú de Ajustes, junto con **Countries**.
- Validaciones de formularios y mensajes de éxito/advertencia visibles.

---

## 👨‍💻 Experiencia de usuario
- Autocompletado de nombre y apellido al ingresar DNI.
- Confirmaciones al eliminar registros.
- Mensajes de éxito al crear, actualizar o eliminar trabajadores.
- Filtros y búsquedas por DNI, nombre o apellido.

---

## 🔄 Flujo de uso
1. Ingresar a **Ajustes → Workers** en el menú lateral.
2. Crear un nuevo trabajador ingresando su DNI.
3. Autocompletar nombre y apellido mediante la API.
4. Guardar el registro.
5. Editar, eliminar o consultar detalles según sea necesario.

---

## 📁 Estructura de vistas Blade

- `resources/views/setting_management/workers/index.blade.php`  
- `resources/views/setting_management/workers/create.blade.php`  
- `resources/views/setting_management/workers/edit.blade.php`  
- `resources/views/setting_management/workers/show.blade.php`  

### Partials
- `resources/views/setting_management/workers/partials/table.blade.php`  
- `resources/views/setting_management/workers/partials/filters.blade.php`  
- `resources/views/setting_management/workers/partials/scripts.blade.php`  

---

## ⚙️ Configuración de la API
El módulo utiliza una API pública de RENIEC/SUNAT para autocompletar los datos al ingresar el DNI.

### 📝 Pasos
1. Abrir el archivo `.env` en la raíz del proyecto Laravel.
2. Agregar la línea con tu token de la API:

```env
API_PERU_TOKEN=TU_TOKEN_AQUI
