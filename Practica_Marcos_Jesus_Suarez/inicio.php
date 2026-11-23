<!--LOGICA -->
<?php
session_start();
require_once 'seguridad.php';
filtrar_acceso(false);

require_once 'funciones.php';
require_once 'conexion.php';

$stmt = $conexion->prepare(
    'SELECT max_lote, num_emojis, max_contactos FROM configuracion WHERE id = 1'
);
$stmt->execute();
$configuracion = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conexion->prepare(
    'SELECT COUNT(*) FROM contactos WHERE codigousu = ?'
);
$stmt->execute([$_SESSION['usuario']['codigo']]);
$contactosExistentes = (int) $stmt->fetchColumn();

$espaciosEmojis = max(0, (int)$configuracion['max_contactos'] - $contactosExistentes);
$maximoEmojis = min((int)$configuracion['max_lote'], $espaciosEmojis);
$emojis = emojisDisponibles((int)$configuracion['num_emojis']);

if (($_POST['accion'] ?? '') === 'grabar') {
    header('Location: agenda.php');
    exit;
}

if ($maximoEmojis === 0) {
    $_SESSION['emojisLote'] = [];
    header('Location: agenda.php');
    exit;
}

if (!isset($_SESSION['emojisLote'])) {
    $_SESSION['emojisLote'] = [emojiAleatorio($emojis)];
}

if (($_POST['accion'] ?? '') === 'incrementar' &&
    count($_SESSION['emojisLote']) < $maximoEmojis) {
    $_SESSION['emojisLote'][] = emojiAleatorio($emojis);
}

if (count($_SESSION['emojisLote']) >= $maximoEmojis) {
    header('Location: agenda.php');
    exit;
}

?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Inicio</title>
        <style>
            * { text-align: center; }
        </style>
    </head>
    <body>
        <p>Usuario: <?= $_SESSION['usuario']['nombre']?></p>

        <?php foreach ($_SESSION['emojisLote'] as $emoji): ?>
            <p><?= $emoji ?></p>
        <?php endforeach; ?>

        <form method="post">
            <button type="submit" name="accion" value="incrementar">Incrementar</button>
        </form>
        <form method="post">
            <button type="submit" name="accion" value="grabar">Grabar</button>
        </form>
    </body>
</html>