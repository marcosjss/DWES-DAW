<?php
session_start();
require_once 'seguridad.php';
filtrar_acceso(false);
require_once 'pintar-circulos.php';

if (($_POST['accion'] ?? '') === 'comenzar_juego' && ($_SESSION['fase'] ?? '') === 'memorizacion') {
    $_SESSION['fase'] = 'juego';
}

if (isset($_POST['color_pulsado']) && ($_SESSION['fase'] ?? '') === 'juego') {
    $coloresDisponibles = numero_colores($colores, $nColores);
    $colorPulsado = $_POST['color_pulsado'];

    if (in_array($colorPulsado, $coloresDisponibles, true) && count($_SESSION['jugada'] ?? []) < $nCirculos) {
        $_SESSION['jugada'][] = $colorPulsado;
    }

    if (count($_SESSION['jugada'] ?? []) === $nCirculos) {
        $acierto = $_SESSION['jugada'] === $_SESSION['combinacion'];
        $stmt = $conexion->prepare('INSERT INTO jugadas (codigousu, acierto) VALUES (?, ?)');
        $stmt->execute([$_SESSION['usuario']['Codigo'], (int) $acierto]);
        $_SESSION['fase'] = 'resultado';
        $_SESSION['acierto'] = $acierto;
        header('Location: ' . ($acierto ? 'acierto.php' : 'fallo.php'));
        exit();
    }
}

if (($_SESSION['fase'] ?? '') !== 'juego') {
    header('Location: inicio.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Simon - Juego</title>
        <style>
            * { text-align: center; }
            html {
                background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>
            }
        </style>
    </head>
    <body>
        <h1>Introduce la combinación</h1>
        <?php pintar_circulos($_SESSION['jugada'] ?? [], $nCirculos); ?>
        <form method="post" id="form-colores">
            <?php for ($x = 0; $x < $nColores; $x++): ?>
                <button type="submit" name="color_pulsado" value="<?= $colores[$x] ?>" style="background-color: <?= $colores[$x] ?>;">
                    <?= $coloresESP[$x] ?>
                </button>
            <?php endfor; ?>
        </form>
    </body>
</html>