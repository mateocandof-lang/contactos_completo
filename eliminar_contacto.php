<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit(); }
include 'conexion.php';

$id_contacto = $_GET['id'] ?? null;
$id_usuario = $_SESSION['usuario_id'];

// Se ejecuta la eliminación asegurando que coincida el id del contacto y el id del usuario propietario
$stmt = $pdo->prepare("DELETE FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id_contacto, $id_usuario]);

header("Location: dashboard.php");
exit();
?>