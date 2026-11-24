## URL pública

- **HTTP:** [http://agenda-contactosutpl.free.je/login.php](http://agenda-contactosutpl.free.je/login.php)
- **HTTPS:** [https://agenda-contactosutpl.free.je/login.php](https://agenda-contactosutpl.free.je/login.php)

La aplicación está publicada en InfinityFree y la página de inicio de sesión es accesible desde Internet. Las funciones que requieren iniciar sesión se verificarán con las capturas de pantalla.

## Repositorio
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

<img width="1913" height="1026" alt="image" src="https://github.com/user-attachments/assets/c1cd4906-58c6-4cae-8c1e-6566bfa24b6c" />
<img width="1919" height="949" alt="image" src="https://github.com/user-attachments/assets/a848d6b3-fac9-4ef7-80bb-21860f29d677" />
<img width="1919" height="1021" alt="image" src="https://github.com/user-attachments/assets/0b094bd0-654c-4eff-87be-2412c1ae09d3" />
<img width="1919" height="1033" alt="image" src="https://github.com/user-attachments/assets/8793bb5d-34d7-4a2d-94d1-b5b3a44a05c3" />
<img width="1919" height="929" alt="image" src="https://github.com/user-attachments/assets/164ce384-003d-485d-aefe-be5386332c8e" />



