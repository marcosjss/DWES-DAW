<!-- LOGICA -->
<?php
session_start();
require_once 'seguridad.php';
filtrar_acceso(false);
require_once 'conexion.php';

if (isset($_SESSION['grabado'])) {
    $resultado = $_SESSION['grabado'];
    unset($_SESSION['grabado']);
} else {
    $valores = $_SESSION['contactosPendientes'] ?? null;
    $emojis = $_SESSION['emojisLote'] ?? null;

    if (!is_array($valores) || !is_array($emojis) || count($valores) === 0 || count($valores) !== count($emojis)) {
        header('Location: inicio.php');
        exit;
    }

    $numeroGrabado = count($valores);
    $errorBD = '';

    try {
        $conexion->beginTransaction();
        $stmt = $conexion->prepare(
            'INSERT INTO contactos
             (codigousu, nombre, apellidos, telefono, email, emoji, fecha)
             VALUES (?, ?, ?, ?, ?, ?, NOW())'
        );

        foreach ($valores as $indice => $contacto) {
            $stmt->execute([
                $_SESSION['usuario']['codigo'],
                trim($contacto['nombre']),
                trim($contacto['apellidos']),
                trim($contacto['telefono']),
                trim($contacto['email']),
                $emojis[$indice]
            ]);
        }

        $stmt = $conexion->prepare(
            'SELECT COUNT(*) FROM contactos WHERE codigousu = ?'
        );
        $stmt->execute([$_SESSION['usuario']['codigo']]);
        $totalAgenda = (int) $stmt->fetchColumn();
        $conexion->commit();

        unset($_SESSION['contactosPendientes'], $_SESSION['emojisLote']);
        $_SESSION['grabado'] = [
            'cantidad' => $numeroGrabado,
            'total' => $totalAgenda
        ];
        header('Location: grabado.php');
        exit;
    } catch (PDOException $e) {
        if ($conexion->inTransaction()) {
            $conexion->rollBack();
        }
        $errorBD = 'No se han podido guardar los datos. Puedes volver a intentarlo.';
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contactos grabados</title>
        <style>
        * { text-align: center;}
        </style>
    </head>
    <body>
        <h1>Resultado del lote</h1>
        <p>Usuario: <?= $_SESSION['usuario']['nombre'] ?></p>

        <?php if (isset($resultado)): ?>
            <p>Se han grabado <b><?= (int) $resultado['cantidad'] ?></b> contactos en tu agenda</p>
            <p>Tu agenda tiene <b><?= (int) $resultado['total'] ?></b> contactos</p>
        <?php else: ?>
            <p><?= $errorBD ?></p>
        <?php endif; ?>

        <p><a href="inicio.php">Grabar más contactos</a></p>
        <p><a href="totales.php">Ver totales</a></p>
		<a href="cierre.php?accion=cerrar_sesion">Cerrar sesión</a>
    </body>
</html>