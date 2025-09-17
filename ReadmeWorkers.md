# Base APP - Workers Module
---

## 📌 Descripción
Se implementó un módulo completo de **Trabajadores (Workers)** dentro del sistema, siguiendo buenas prácticas de segmentación y organización de archivos. Este módulo permite gestionar de manera eficiente la información de los trabajadores, integrando autocompletado de datos mediante una API pública.

---

## 🚀 Funcionalidades

### CRUD Completo de Trabajadores
- **Listado:** Visualización de todos los trabajadores con paginación y filtros por documento, nombre o apellido.
- **Creación:** Registro de nuevos trabajadores ingresando su **DNI**.
- **Edición:** Modificación de datos existentes de trabajadores.
- **Eliminación:** Eliminación de registros con **motivo de eliminación**, respetando auditoría del sistema.

### Campos principales del trabajador
- **ID automático**
- **Documento de identidad (DNI)**
- **Nombre**
- **Apellido**

### Autocompletado de datos mediante API
- Al ingresar el **DNI** de un trabajador al crear un registro, el sistema consulta automáticamente la **API pública de RENIEC/SUNAT** para rellenar los campos de **nombre** y **apellido**.
- La API utilizada se obtiene de: [https://apis.net.pe/consulta-ruc-php.html](https://apis.net.pe/consulta-ruc-php.html)
- La configuración de la API se realiza a través del archivo `.env`, permitiendo cambiar de proveedor sin modificar el código del controlador.

### Organización y buenas prácticas
- **Controlador centralizado (`WorkerController`)** que maneja toda la lógica del módulo.
- **Separación de vistas y scripts:** formularios, tablas y modales están en archivos Blade independientes. Los scripts de interacción y validaciones están en un archivo separado.
- **Traducciones centralizadas** para todos los textos del módulo.
- **Integración en la navegación:** el módulo Workers se encuentra dentro del menú de **Ajustes**, junto con **Countries**, respetando la jerarquía del sidebar.
- **Validaciones de formularios** y mensajes de advertencia o éxito visibles.

### Experiencia de usuario
- Autocompletado de nombre y apellido al ingresar DNI.
- Confirmaciones al eliminar registros.
- Mensajes de éxito al crear, actualizar o eliminar trabajadores.
- Filtros y búsquedas por DNI, nombre o apellido.

---

## 📝 Flujo de uso
1. Ingresar a **Ajustes → Workers** en el menú lateral.
2. Crear un nuevo trabajador ingresando su **DNI**.
3. El sistema autocompleta automáticamente los campos de nombre y apellido mediante la API.
4. Guardar el registro.
5. Editar, eliminar o consultar detalles según sea necesario.

---

## ⚙️ Instalación y Configuración
1. Clonar el repositorio:
   ```bash
   git clone https://github.com/tu_usuario/tu_repositorio.git
