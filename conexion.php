<?php
$current_host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? 'localhost')[0]);
$es_local = in_array($current_host, ['localhost', '127.0.0.1'], true);

if ($es_local) {
    $host = 'localhost';
    $dbname = 'agenda_db';
    $username = 'root';
    $password = '';
} else {
    $host = 'sql212.infinityfree.com';
    $dbname = 'if0_43510223_agendautpl';
    $username = 'if0_43510223';
    $password = 'CAMBIA_ESTE_TEXTO_POR_TU_PASSWORD';

    if ($password === 'CAMBIA_ESTE_TEXTO_POR_TU_PASSWORD') {
        http_response_code(500);
        exit('Configura la contraseña de MySQL de InfinityFree en conexion.php.');
    }
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>