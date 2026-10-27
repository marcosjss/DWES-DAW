<?php
    session_start();
    require_once 'seguridad.php';
    filtrar_acceso(true);
    require_once 'pintar-circulos.php';

    function crearCookie($nombreCookie, $valorCookie) {
        setcookie($nombreCookie, $valorCookie, [
            'expires' => time() + 30 * 24 * 60 * 60,
            'path' => '/',
            'domain' => 'localhost',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['accion'] ?? '') === 'fondo') {
        crearCookie('cColor', $_POST['cColor']);
        $colorFondo = $_POST['cColor'];
    }

    if (isset($_POST['nCirculos'], $_POST['nColores'])) {
        $nCirculos = $_POST['nCirculos'];
        $nColores = $_POST['nColores'];

        if ($nCirculos >= 4 && $nCirculos <= 8 &&
            $nColores >= 4 && $nColores <= 8) {
        $stmt = $conexion->prepare(
            'UPDATE configuracion SET nCirculos = ?, nColores = ? WHERE id = 1'
        );
        $stmt->execute([$nCirculos, $nColores]);
        }
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
        <form method="post">
            <p>Color de fondo
                <input name="cColor" value="<?= $colorFondo ?>" required>
                <button type="submit" name="accion" value="fondo">Cambiar color</button>
            </p>
        </form>
        <form method="post" action="cierre.php">
            <button type="submit" name="accion" value="cerrar_sesion">Cerrar sesión</button>
        </form>
    </body>
</html>