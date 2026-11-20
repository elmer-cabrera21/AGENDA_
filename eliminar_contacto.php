<?php
require __DIR__ . '/config.php';
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit; }

// CORRECCIÓN 2: Recibimos el ID por POST, no por GET
$id_contacto = $_POST['id_contacto'] ?? 0;
$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("DELETE FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id_contacto, $id_usuario]);

header("Location: index.php");
exit;
?>