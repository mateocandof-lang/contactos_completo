<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$id_usuario = $_SESSION['usuario_id'];
$busqueda = trim($_GET['busqueda'] ?? '');
$solo_favoritos = isset($_GET['favoritos']) && $_GET['favoritos'] === '1';
$id_categoria = filter_var($_GET['categoria'] ?? '', FILTER_VALIDATE_INT);
$ordenes = [
    'nombre' => 'contactos.nombre',
    'ciudad' => 'contactos.ciudad',
    'fecha' => 'contactos.fecha_creacion',
];
$orden = $_GET['orden'] ?? 'nombre';
if (!isset($ordenes[$orden])) {
    $orden = 'nombre';
}

$categorias = $pdo->query("SELECT id, nombre FROM categorias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$sql = "SELECT contactos.*, categorias.nombre AS categoria_nombre
        FROM contactos
        INNER JOIN categorias ON categorias.id = contactos.id_categoria
        WHERE contactos.id_usuario = ?";
$parametros = [$id_usuario];

if ($busqueda !== '') {
    $sql .= " AND (contactos.nombre LIKE ? OR contactos.correo LIKE ? OR contactos.ciudad LIKE ?)";
    $termino = '%' . $busqueda . '%';
    array_push($parametros, $termino, $termino, $termino);
}
if ($solo_favoritos) {
    $sql .= " AND contactos.favorito = 1";
}
if ($id_categoria !== false && $id_categoria !== null) {
    $sql .= " AND contactos.id_categoria = ?";
    $parametros[] = $id_categoria;
}

$sql .= " ORDER BY " . $ordenes[$orden] . " ASC, contactos.id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($parametros);
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Panel Principal - Agenda</title>
</head>
<body>
<main class="container dashboard-container">
    <header class="header-panel">
        <div>
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><?php echo htmlspecialchars($_SESSION['usuario_correo'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <a class="btn btn-secondary" href="logout.php">Cerrar sesión</a>
    </header>

    <section class="contacts-heading">
        <div>
            <h3>Mis contactos</h3>
            <p>Administra y encuentra rápidamente tus contactos.</p>
        </div>
        <a class="btn" href="crear_contacto.php">Agregar contacto</a>
    </section>

    <form class="filters" action="dashboard.php" method="GET">
        <div class="filter-field search-field">
            <label for="busqueda">Buscar</label>
            <input id="busqueda" type="search" name="busqueda" value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Nombre, correo o ciudad">
        </div>
        <div class="filter-field">
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria">
                <option value="">Todas</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo (int) $categoria['id']; ?>" <?php echo $id_categoria == $categoria['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-field">
            <label for="orden">Ordenar por</label>
            <select id="orden" name="orden">
                <option value="nombre" <?php echo $orden === 'nombre' ? 'selected' : ''; ?>>Nombre</option>
                <option value="ciudad" <?php echo $orden === 'ciudad' ? 'selected' : ''; ?>>Ciudad</option>
                <option value="fecha" <?php echo $orden === 'fecha' ? 'selected' : ''; ?>>Fecha de creación</option>
            </select>
        </div>
        <label class="favorite-filter">
            <input type="checkbox" name="favoritos" value="1" <?php echo $solo_favoritos ? 'checked' : ''; ?>>
            Solo favoritos
        </label>
        <div class="filter-actions">
            <button type="submit">Aplicar filtros</button>
            <a class="btn btn-secondary" href="dashboard.php">Limpiar</a>
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Ciudad</th>
                    <th>Categoría</th>
                    <th>Favorito</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactos as $contacto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contacto['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($contacto['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($contacto['correo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($contacto['ciudad'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($contacto['categoria_nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo (int) $contacto['favorito'] === 1 ? 'Sí' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($contacto['fecha_creacion'])), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="actions">
                            <a href="editar_contacto.php?id=<?php echo (int) $contacto['id']; ?>">Editar</a>
                            <a class="delete-link" href="eliminar_contacto.php?id=<?php echo (int) $contacto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este contacto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($contactos)): ?>
                    <tr><td class="empty-state" colspan="8">No se encontraron contactos con esos filtros.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
