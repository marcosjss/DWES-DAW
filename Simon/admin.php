<?php
    session_start();
    require_once 'seguridad.php';
    filtrar_acceso(true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nCirculos = $_POST['nCirculos'] ?? null;
    $nColores = $_POST['nColores'] ?? null;

    if ($nCirculos >= 4 && $nCirculos <= 8 &&
        $nColores >= 4 && $nColores <= 8) {
        $conexion = require 'conexion.php';
        $stmt = $conexion->prepare(
            'UPDATE configuracion SET nCirculos = ?, nColores = ? WHERE id = 1'
        );
        $stmt->execute([$nCirculos, $nColores]);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <style>
            * { text-align: center; }
            html {
                background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>
            }
        </style>
    </head>
    <body>
        <h1>Panel de administracion</h1>
        <h3>Conectado como Administrador:<?= htmlspecialchars($_SESSION['usuario']['Nombre'] ?? '') ?></h3>
        <form method="post">
            <p>Número de círculos (4-8):
                <input type="number" id="nCirculos" name="nCirculos" min="4" max="8" value="<?= $nCirculos ?>" required>
            </p>
            <p>Número de colores (4-8):
                <input type="number" id="nColores" name="nColores" min="4" max="8" value="<?= $nColores ?>" required>
            </p>
            <button type="submit">Actualizar</button>
        </form>
        <form method="post" action="cierre.php">
            <button type="submit" name="accion" value="cerrar_sesion">Cerrar sesión</button>
        </form>
    </body>
</html>