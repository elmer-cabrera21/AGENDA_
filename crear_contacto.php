<?php
require __DIR__ . '/config.php';
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $ciudad = trim($_POST['ciudad']);
    $id_usuario = $_SESSION['usuario_id'];

    // CORRECCIÓN 3: Validación de formato de correo en el servidor
    if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Error: El formato del correo electrónico no es válido.";
    } elseif (!empty($nombre)) {
        $stmt = $pdo->prepare("INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $nombre, $telefono, $correo, $ciudad]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Agregar Contacto</h2>
    
    <?php if($error) echo "<p class='mensaje-error'>$error</p>"; ?>

    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>Teléfono:</label>
        <input type="text" name="telefono">
        <label>Correo:</label>
        <input type="text" name="correo">
        <label>Ciudad:</label>
        <input type="text" name="ciudad">
        <button type="submit">Guardar</button>
    </form>
    <a href="index.php">Volver a la Agenda</a>
</body>
</html>