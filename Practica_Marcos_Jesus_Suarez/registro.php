<?php
    session_start();
    require_once 'cierre.php';
    $nombreNuevo = '';
    $mensaje = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreNuevo = trim(is_string($_POST['nuevo_usuario'] ?? null) ? $_POST['nuevo_usuario'] : '');
        $claveNueva = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

        if ($nombreNuevo === '' || $claveNueva === '') {
            $mensaje = 'Escribe usuario y contraseña.';
        } else {
            try {
                $conexion = require 'conexion.php';
                $sql = "INSERT INTO usuarios (nombre, passwrd, rol) VALUES (?, ?, 0)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$nombreNuevo, password_hash($claveNueva, PASSWORD_DEFAULT)]);

                $_SESSION['usuario_id'] = (int) $conexion->lastInsertId();
                $_SESSION['usuario_nombre'] = $nombreNuevo;
                header('Location: index.php');
                $conexion = cierre();
                exit;
            } catch (PDOException $e) {
                error_log('Error al registrar usuario: ' . $e->getMessage());
                $mensaje = "Este usuario ya existe o un campo es incorrecto";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <style>
            * { text-align: center; }
        </style>
    </head>
    <body>
        <h1>Registro</h1>
        <form method="post">
            <p>Usuario:
                <input type="text" name="nuevo_usuario" maxlength="20" value="<?= $nombreNuevo ?>" required>
            </p>
            <p>Contraseña:
                <input type="password" name="password" required>
            </p>
            <button type="submit">Registrarse</button>
            <p style="color: red"><?= $mensaje ?></p>
        </form>
        <button type="button" onclick="window.location.href='index.php'">Volver al login</button>
    </body>
</html>
