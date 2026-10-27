<?php
session_start();
require_once 'seguridad.php';
filtrar_acceso(false);

if (($_SESSION['fase'] ?? '') !== 'resultado' || ($_SESSION['acierto'] ?? true) !== false) {
    header('Location: inicio.php');
    exit();
}

require_once 'pintar-circulos.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Simon - Fallo</title>
        <style>
            * { text-align: center; }
            html {
                background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>
            }
        </style>
    </head>
    <body>
        <h2>SIMÓN</h2>
        <p><?= htmlspecialchars($_SESSION['usuario']['Nombre'], ENT_QUOTES, 'UTF-8') ?>, lo sentimos, has fallado</p>
        <p>La combinación era:</p>
        <?php pintar_circulos($_SESSION['combinacion'], $_SESSION['nCirculos']); ?>
        <p>Tu combinación elegida fue:</p>
        <?php pintar_circulos($_SESSION['jugada'], $_SESSION['nCirculos']); ?>
        <p>Se ha guardado en la base de datos (acierto = 0)</p>
        <form action="inicio.php">
            <button type="submit">Volver a jugar</button>
        </form>
        <form action="estadistica.php">
            <button type="submit">Estadística</button>
        </form>
        <form method="post" action="cierre.php">
            <button type="submit" name="accion" value="cerrar_sesion">Cerrar sesión</button>
        </form>
    </body>
</html>