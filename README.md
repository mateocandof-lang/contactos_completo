# Agenda Personal de Contactos

Aplicación web en PHP y MySQL para registrar, buscar y administrar contactos personales.

## URL pública

- HTTP: [http://agenda-contactosutpl.free.ie/login.php](http://agenda-contactosutpl.free.ie/login.php)
- HTTPS: [https://agenda-contactosutpl.free.ie/login.php](https://agenda-contactosutpl.free.ie/login.php)

**Estado del despliegue:** el dominio fue creado y el código se subió a InfinityFree, pero durante la verificación el sitio devolvió un error 403 por HTTP y un error de certificado por HTTPS. La aplicación todavía debe validarse antes de considerarla disponible para evaluación.

## Repositorio

[https://github.com/mateocandof-lang/contactos_completo](https://github.com/mateocandof-lang/contactos_completo)

## Tecnologías

- PHP
- MySQL
- HTML5
- CSS3
- PDO para consultas parametrizadas

## Mejoras implementadas

- Búsqueda de contactos por nombre, correo electrónico o ciudad.
- Ordenamiento ascendente por nombre, ciudad o fecha de creación.
- Categorías para cada contacto: Familia, Amigos, Trabajo, Universidad y Otro.
- Marcado de contactos como favoritos y filtro para mostrar únicamente los favoritos.
- Validación de campos obligatorios y del formato del correo electrónico.
- Consultas parametrizadas para las operaciones de contactos.

## Instalación local

1. Instala XAMPP o un entorno equivalente con PHP, MySQL y Apache.
2. Copia la carpeta del proyecto dentro de `htdocs`.
3. En phpMyAdmin, selecciona la base `agenda_db` e importa `database.sql` para una instalación nueva.
4. Si ya tienes una base anterior con las tablas `usuarios` y `contactos`, respáldala e importa `migration_mejoras.sql` una sola vez, teniendo seleccionada la base correcta. No importes `database.sql` encima de una base existente.
5. Inicia Apache y MySQL. La configuración local predeterminada utiliza `localhost`, la base `agenda_db` y el usuario `root` sin contraseña.
6. Abre `http://localhost:8081/agenda_php/registro.php` (ajusta el puerto si Apache usa uno distinto), registra un usuario e inicia sesión.

## Base de datos

- `agenda_db.sql`: esquema completo para una instalación nueva, con las cinco categorías iniciales.
- `migration_mejoras.sql`: agrega categorías, favoritos y fecha de creación a una instalación anterior, y asigna la categoría “Otro” a los contactos existentes. Haz una copia de seguridad antes de ejecutarlo y ejecútalo una sola vez con la base de destino seleccionada.

## Despliegue en InfinityFree

1. Crea una base MySQL desde el panel de InfinityFree e importa una copia de la base local.
2. Sube los archivos PHP y `style.css` a la carpeta `htdocs` del hosting.
3. Edita el `conexion.php` del hosting y configura la contraseña de MySQL de InfinityFree. No publiques esa contraseña en GitHub ni la compartas.
4. Prueba las funciones del sitio y verifica que el dominio funcione antes de presentar la URL.

No subas respaldos SQL con datos personales a la carpeta pública del hosting ni al repositorio.

## Capturas de pantalla

Pendientes: agregar capturas reales de la aplicación funcionando, incluyendo el inicio de sesión y el panel con las mejoras implementadas.
