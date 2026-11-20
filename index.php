<?php
require __DIR__ . '/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// --- LÓGICA DE BÚSQUEDA (Opción A) ---
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// --- LÓGICA DE ORDENAMIENTO (Opción B) ---
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre';
$direccion = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC';

$columnas_permitidas = ['nombre', 'ciudad', 'correo', 'telefono'];
if (!in_array($orden, $columnas_permitidas)) {
    $orden = 'nombre';
}

$sql = "SELECT * FROM contactos WHERE id_usuario = ?";
$parametros = [$id_usuario];

if (!empty($buscar)) {
    $sql .= " AND (nombre LIKE ? OR correo LIKE ? OR ciudad LIKE ?)";
    $parametros[] = "%$buscar%";
    $parametros[] = "%$buscar%";
    $parametros[] = "%$buscar%";
}

$sql .= " ORDER BY $orden $direccion";

$stmt = $pdo->prepare($sql);
$stmt->execute($parametros);
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Agenda</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        /* ESTO ARREGLA EL CUADRO BLANCO DEL FORMULARIO EN LA TABLA */
        table form {
            display: inline;
            margin: 0;
            padding: 0;
            background: transparent;
            box-shadow: none;
            border: none;
        }
        table form a {
            color: #e74c3c;
            text-decoration: none;
        }
        table form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header-panel">
        <h1>Mi Agenda Personal</h1>
        <div>
            <span>Hola, <strong><?= htmlspecialchars($_SESSION['usuario_nombre']) ?></strong> (<?= htmlspecialchars($_SESSION['usuario_correo']) ?>)</span>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>

    <div style="width: 100%; max-width: 800px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Mis Contactos</h2>
        <a href="crear_contacto.php" style="background: #27ae60; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none;">+ Nuevo Contacto</a>
    </div>

    <form method="GET" style="max-width: 800px; display: flex; gap: 10px; padding: 15px; margin-bottom: 20px; box-shadow: none; background: transparent;">
        <input type="text" name="buscar" placeholder="Buscar por nombre, correo o ciudad..." value="<?= htmlspecialchars($buscar) ?>" style="margin-bottom: 0; flex: 1;">
        <button type="submit" style="width: auto; background-color: #2c3e50;">Buscar</button>
        <?php if(!empty($buscar)): ?>
            <a href="index.php" style="padding: 10px; color: #e74c3c; font-weight: bold; align-self: center;">Limpiar</a>
        <?php endif; ?>
    </form>
    
    <table>
        <tr>
            <th>
                <a href="index.php?orden=nombre&dir=<?= ($orden == 'nombre' && $direccion == 'ASC') ? 'desc' : 'asc' ?>&buscar=<?= urlencode($buscar) ?>" style="color: white; text-decoration: none;">
                    Nombre <?= ($orden == 'nombre') ? ($direccion == 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>
                <a href="index.php?orden=telefono&dir=<?= ($orden == 'telefono' && $direccion == 'ASC') ? 'desc' : 'asc' ?>&buscar=<?= urlencode($buscar) ?>" style="color: white; text-decoration: none;">
                    Teléfono <?= ($orden == 'telefono') ? ($direccion == 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>
                <a href="index.php?orden=correo&dir=<?= ($orden == 'correo' && $direccion == 'ASC') ? 'desc' : 'asc' ?>&buscar=<?= urlencode($buscar) ?>" style="color: white; text-decoration: none;">
                    Correo <?= ($orden == 'correo') ? ($direccion == 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>
                <a href="index.php?orden=ciudad&dir=<?= ($orden == 'ciudad' && $direccion == 'ASC') ? 'desc' : 'asc' ?>&buscar=<?= urlencode($buscar) ?>" style="color: white; text-decoration: none;">
                    Ciudad <?= ($orden == 'ciudad') ? ($direccion == 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>Acciones</th>
        </tr>
        
        <?php if(count($contactos) > 0): ?>
            <?php foreach($contactos as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td><?= htmlspecialchars($c['telefono']) ?></td>
                <td><?= htmlspecialchars($c['correo']) ?></td>
                <td><?= htmlspecialchars($c['ciudad']) ?></td>
                <td style="white-space: nowrap;">
                    <a href="editar_contacto.php?id=<?= $c['id'] ?>" style="margin-right: 15px;">Editar</a> 
                    
                    <form method="POST" action="eliminar_contacto.php" id="form-eliminar-<?= $c['id'] ?>">
                        <input type="hidden" name="id_contacto" value="<?= $c['id'] ?>">
                        <a href="#" onclick="if(confirm('¿Seguro que deseas eliminar este contacto?')) { document.getElementById('form-eliminar-<?= $c['id'] ?>').submit(); } return false;">Eliminar</a>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">No se encontraron contactos con ese criterio de búsqueda.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>