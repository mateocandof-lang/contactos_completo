<?php
include 'conexion.php';
$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $pass = $_POST['password'];

    if (empty($nombre) || empty($correo) || empty($pass)) {
        $error = "Todos los campos son obligatorios.";
    } else {

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        if ($stmt->rowCount() > 0) {
            $error = "El correo electrónico ya está registrado.";
        } else {
            // Cifrar contraseña
            $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $correo, $passwordHash])) {
                $exito = "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
            } else {
                $error = "Ocurrió un error al registrar el usuario.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Registro de Usuario</title>
</head>
<body>
<main class="container auth-container">
    <h2>Registro de Nuevos Usuarios</h2>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if($exito) echo "<p style='color:green;'>$exito</p>"; ?>
    <form action="registro.php" method="POST">
        <label>Nombre Completo:</label><br>
        <input type="text" name="nombre" required><br><br>
        <label>Correo Electrónico:</label><br>
        <input type="email" name="correo" required><br><br>
        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</main>
</body>
</html>
