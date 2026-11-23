<?php
session_start();
include 'conexion.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($pass, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_correo'] = $usuario['correo'];
        header('Location: dashboard.php');
        exit();
    }

    $error = 'Correo o contraseña incorrectos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container auth-container login-card">
        <div class="login-heading">
            <span class="login-icon" aria-hidden="true">👤</span>
            <h2>Iniciar sesión</h2>
            <p class="login-subtitle">Ingresa tus datos para acceder a tu agenda</p>
        </div>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="correo">Correo electrónico</label>
            <input id="correo" type="email" name="correo" placeholder="tu@correo.com" autocomplete="email" required>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="Escribe tu contraseña" autocomplete="current-password" required>

            <button class="login-submit" type="submit">Iniciar sesión</button>
        </form>

        <p class="link-row">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </main>
</body>
</html>
