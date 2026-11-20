<?php
require __DIR__ . '/config.php';

function saludar($mensaje, $tipo = 'exito') {
    $clase = ($tipo == 'error') ? 'mensaje-error' : 'mensaje-exito';
    echo "<p class='$clase'>$mensaje</p>";
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($pass, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_correo'] = $usuario['correo'];
        $_SESSION['mensaje_saludo'] = "¡Hola de nuevo, " . $usuario['nombre'] . "!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    <?php if($error) saludar($error, 'error'); ?>

    <form method="POST">
        <label>Correo:</label>
        <input type="email" name="correo" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Entrar</button>
    </form>
    <p><a href="registro.php">Crear una cuenta nueva</a></p>
</body>
</html>