<?php
require __DIR__ . '/config.php';

function saludar($mensaje, $tipo = 'exito') {
    $clase = ($tipo == 'error') ? 'mensaje-error' : 'mensaje-exito';
    echo "<p class='$clase'>$mensaje</p>";
}

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
        if ($stmt->fetch()) {
            $error = "El correo ya está registrado.";
        } else {
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $correo, $passHash])) {
                $exito = "Registro exitoso. Ya puedes iniciar sesión.";
            } else {
                $error = "Error al registrar.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Registro de Usuario</h2>
    
    <?php 
    if($error) saludar($error, 'error'); 
    if($exito) saludar($exito, 'exito'); 
    ?>

    <form method="POST">
        <label>Nombre completo:</label>
        <input type="text" name="nombre" required>
        <label>Correo:</label>
        <input type="email" name="correo" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Registrarse</button>
    </form>
    <p><a href="login.php">Ir al Login</a></p>
</body>
</html>