# Agenda Personal de Contactos

Aplicación web en PHP y MySQL para registrar y administrar contactos personales.

## URL pública

Pendiente: la aplicación aún no se ha desplegado. Se agregará aquí la URL pública al completar la etapa de hosting.

## Tecnologías

- PHP
- MySQL
- HTML5
- CSS3
- PDO para consultas parametrizadas

## Mejoras implementadas

- Búsqueda por nombre, correo electrónico o ciudad.
- Ordenamiento ascendente por nombre, ciudad o fecha de creación.
- Categorías por contacto: Familia, Amigos, Trabajo, Universidad y Otro.
- Marcado de contactos como favoritos y filtro para mostrar únicamente los favoritos.
- Validación de campos y correo en los formularios de contacto.

## Instalación local

1. Instala un entorno local con PHP, MySQL y un servidor web (por ejemplo, XAMPP).
2. Copia el proyecto en el directorio público del servidor web.
3. Para una instalación nueva, importa `database.sql` en MySQL para crear las tablas y categorías. Si ya tienes la base de datos anterior con las tablas `usuarios` y `contactos`, no importes `database.sql`: realiza primero una copia de seguridad e importa `migration_mejoras.sql` una sola vez con `agenda_db` seleccionada. En un hosting con un nombre de base distinto, selecciona esa base antes de importar el archivo.
4. Configura las credenciales de MySQL en `conexion.php`.
5. Inicia Apache y MySQL y abre `http://localhost/agenda_php/registro.php`.
6. Registra un usuario e inicia sesión para administrar contactos.

## Base de datos

- `database.sql`: instalación nueva, incluye el esquema completo y las categorías iniciales.
- `migration_mejoras.sql`: actualización de una instalación anterior. Agrega las categorías, favoritos y fecha de creación; asigna la categoría “Otro” a los contactos existentes. Ejecutar una sola vez y después de respaldar la base de datos.

## Capturas de pantalla

Pendientes: se agregarán capturas de la aplicación funcionando en línea durante la etapa de despliegue.
