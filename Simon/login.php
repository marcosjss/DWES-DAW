<!--LOGICA-->
<?php
    session_start();
    $nombreLogin = '';
    $msgError = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreLogin = $_POST['usuario'] ?? '';
        $claveLogin = $_POST['password'] ?? '';

        if (!is_string($nombreLogin) || !is_string($claveLogin) ||
            trim($nombreLogin) === '' || $claveLogin === '') {
            $msgError = 'Escribe usuario y contraseña.';
        } else {
            $nombreLogin = trim($nombreLogin);
            try {
                $conexion = require 'conexion.php';
                $stmt = $conexion->prepare('SELECT Codigo, Nombre, Clave FROM usuarios WHERE Nombre = ?');
                $stmt->execute([$nombreLogin]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && password_verify($claveLogin, $usuario['Clave'])) {
                    session_regenerate_id(true);
                    $_SESSION['usuario_id'] = (int) $usuario['Codigo'];
                    $_SESSION['usuario_nombre'] = $usuario['Nombre'];
                    header('Location: simon.php');
                    exit;
                }

                $msgError = 'Usuario o contraseña incorrectos.';
            } catch (PDOException $e) {
                error_log('Error al iniciar sesión: ' . $e->getMessage());
                $msgError = 'No se pudo iniciar sesión. Comprueba la conexión.';
            }
        }
    }
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            * {
                text-align:center;
            }
            html { 
                background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>
            }
        </style>
    </head>
    <body>
        <form method="post">
            <p>Usuario:
                <input type="text" id="usuario" name="usuario"
                       value="<?= htmlspecialchars($nombreLogin, ENT_QUOTES, 'UTF-8') ?>" required>
            </p>
            <p>Contraseña:
                <input type="password" id="password" name="password" required>
            </p>
            <button type="submit" name="accion" value="iniciar">Entrar</button>
            <p style="color: red"><?= htmlspecialchars($msgError, ENT_QUOTES, 'UTF-8') ?></p>
        </form>
        <button type="button" onclick="window.location.href='registro.php'">Registro</button>
    </body>
</html>