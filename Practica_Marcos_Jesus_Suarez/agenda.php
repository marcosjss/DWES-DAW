<!-- LOGICA -->
<?php
session_start();
require_once 'funciones.php';
require_once 'conexion.php';

if (empty($_SESSION['emojisLote']) || !is_array($_SESSION['emojisLote'])) {
    header('Location: inicio.php');
    exit;
}

$errorBD='';
$cantidad = count($_SESSION['emojisLote']);
$valores = array_fill(0, $cantidad, []);
$errores = array_fill(0, $cantidad, []);
$hayErrores = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recibidos = $_POST['contactos'] ?? [];

    for ($i = 0; $i < $cantidad; $i++) {
        $contacto = $recibidos[$i] ?? [];
        $valores[$i] = is_array($contacto) ? $contacto : [];
        $errores[$i] = validarContacto($valores[$i]);

        if ($errores[$i] !== []) {
            $hayErrores = true;
        }
    }

    if (!$hayErrores) {
        $_SESSION['contactosPendientes'] = $valores;
        header('Location: grabado.php');
        exit;
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
    <body>
        <p><?= $errorBD, '' ?>
        <form method="post">
            <?php for ($i = 0; $i < $cantidad; $i++): ?>
                <?= pintarFormularioContacto(
                    $i,
                    $_SESSION['emojisLote'][$i],
                    $valores[$i],
                    $errores[$i]
                ) ?>
            <?php endfor; ?>

            <button type="submit">Grabar contactos</button>
        </form>
    </body>
</html>