<?php
session_start();
require_once 'seguridad.php';
filtrar_acceso(false);

if (!in_array($_SESSION['fase'] ?? '', ['memorizacion', 'juego'], true)) {
    unset($_SESSION['nCirculos'], $_SESSION['nColores']);
}

require_once 'pintar-circulos.php';

if (($_POST['accion'] ?? '') === 'reiniciar') {
    unset($_SESSION['fase'], $_SESSION['nCirculos'], $_SESSION['nColores'], $_SESSION['combinacion'], $_SESSION['jugada']);
    header('Location: inicio.php');
    exit();
}

if (($_SESSION['fase'] ?? '') === 'juego') {
    header('Location: jugar.php');
    exit();
}

if (($_SESSION['fase'] ?? '') !== 'memorizacion') {
    $coloresDisponibles = numero_colores($colores, $nColores);
    $_SESSION['nCirculos'] = $nCirculos;
    $_SESSION['nColores'] = $nColores;
    $_SESSION['combinacion'] = [];
    $_SESSION['jugada'] = [];
    unset($_SESSION['acierto']);

    for ($k = 0; $k < $nCirculos; $k++) {
        $_SESSION['combinacion'][] = $coloresDisponibles[array_rand($coloresDisponibles)];
    }

    $_SESSION['fase'] = 'memorizacion';
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Simon - Memorización</title>
        <style>
            * { text-align: center; }
            html {
                background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>
            }
        </style>
    </head>
    <body>
        <h1>Combinación generada</h1>
        <?php pintar_circulos($_SESSION['combinacion'], $nCirculos); ?>
        <form method="post" action="jugar.php">
            <button type="submit" name="accion" value="comenzar_juego">Jugar</button>
        </form>
    </body>
</html>