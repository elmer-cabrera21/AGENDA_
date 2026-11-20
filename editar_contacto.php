<?php
require __DIR__ . '/config.php';
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit; }

$id_contacto = $_GET['id'] ?? 0;
$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT * FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id_contacto, $id_usuario]);
$contacto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contacto) {
    die("Acceso denegado o contacto no encontrado.");
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $ciudad = trim($_POST['ciudad']);

    // CORRECCIÓN 3: Validación de formato de correo en el servidor
    if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Error: El formato del correo electrónico no es válido.";
    } else {
        $stmt = $pdo->prepare("UPDATE contactos SET nombre=?, telefono=?, correo=?, ciudad=? WHERE id=? AND id_usuario=?");
        $stmt->execute([$nombre, $telefono, $correo, $ciudad, $id_contacto, $id_usuario]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Editar Contacto</h2>
    
    <?php if($error) echo "<p class='mensaje-error'>$error</p>"; ?>

    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($contacto['nombre']) ?>" required>
        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($contacto['telefono']) ?>">
        <label>Correo:</label>
        <input type="text" name="correo" value="<?= htmlspecialchars($contacto['correo']) ?>">
        <label>Ciudad:</label>
        <input type="text" name="ciudad" value="<?= htmlspecialchars($contacto['ciudad']) ?>">
        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php">Volver a la Agenda</a>
</body>
</html>