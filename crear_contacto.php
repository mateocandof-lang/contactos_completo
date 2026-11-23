<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

$categorias = $pdo->query("SELECT id, nombre FROM categorias ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$errores = [];
$valores = ['nombre' => '', 'telefono' => '', 'correo' => '', 'ciudad' => '', 'id_categoria' => '', 'favorito' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['nombre', 'telefono', 'correo', 'ciudad'] as $campo) {
        $valores[$campo] = trim($_POST[$campo] ?? '');
    }
    $valores['id_categoria'] = filter_var($_POST['id_categoria'] ?? '', FILTER_VALIDATE_INT);
    $valores['favorito'] = isset($_POST['favorito']);

    foreach (['nombre' => 'Nombre', 'telefono' => 'Teléfono', 'correo' => 'Correo', 'ciudad' => 'Ciudad'] as $campo => $etiqueta) {
        if ($valores[$campo] === '') {
            $errores[] = $etiqueta . ' es obligatorio.';
        }
    }
    if ($valores['correo'] !== '' && !filter_var($valores['correo'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Ingresa un correo electrónico válido.';
    }
    $ids_categorias = array_map('intval', array_column($categorias, 'id'));
    if ($valores['id_categoria'] === false || !in_array($valores['id_categoria'], $ids_categorias, true)) {
        $errores[] = 'Selecciona una categoría válida.';
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare(
            "INSERT INTO contactos (id_usuario, id_categoria, nombre, telefono, correo, ciudad, favorito)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $_SESSION['usuario_id'],
            $valores['id_categoria'],
            $valores['nombre'],
            $valores['telefono'],
            $valores['correo'],
            $valores['ciudad'],
            $valores['favorito'] ? 1 : 0,
        ]);
        header("Location: dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Agregar contacto</title>
</head>
<body>
<main class="container auth-container">
    <h2>Agregar contacto</h2>
    <?php if (!empty($errores)): ?>
        <div class="error" role="alert">
            <?php foreach ($errores as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="crear_contacto.php">
        <label for="nombre">Nombre</label>
        <input id="nombre" type="text" name="nombre" value="<?php echo htmlspecialchars($valores['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="telefono">Teléfono</label>
        <input id="telefono" type="text" name="telefono" value="<?php echo htmlspecialchars($valores['telefono'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="correo">Correo</label>
        <input id="correo" type="email" name="correo" value="<?php echo htmlspecialchars($valores['correo'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="ciudad">Ciudad</label>
        <input id="ciudad" type="text" name="ciudad" value="<?php echo htmlspecialchars($valores['ciudad'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="id_categoria">Categoría</label>
        <select id="id_categoria" name="id_categoria" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo (int) $categoria['id']; ?>" <?php echo $valores['id_categoria'] == $categoria['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="checkbox-field">
            <input type="checkbox" name="favorito" value="1" <?php echo $valores['favorito'] ? 'checked' : ''; ?>>
            Marcar como favorito
        </label>
        <button type="submit">Guardar contacto</button>
    </form>
    <p class="link-row"><a href="dashboard.php">Volver a mis contactos</a></p>
</main>
</body>
</html>
