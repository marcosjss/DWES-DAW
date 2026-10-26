<!--LOGICA-->
<?php
    session_start();
    require_once 'cierre.php';
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
                $stmt = $conexion->prepare('SELECT Codigo, Nombre, Clave, Rol FROM usuarios WHERE Nombre = ?');
                $stmt->execute([$nombreLogin]);
                $usuario = $stmt->fetch();

                if ($usuario && password_verify($claveLogin, $usuario['Clave'])) {
                    $_SESSION['usuario'] = [
                        'Codigo' => (int) $usuario['Codigo'],
                        'Nombre' => $usuario['Nombre'],
                        'Rol' => (int) $usuario['Rol']
                    ];

                    header('Location: ' . ((int) $usuario['Rol'] === 1 ? 'admin.php' : 'simon.php'));
                    exit;
                }

                $msgError = 'Usuario o contraseña incorrectos.';
                $conexion = cerrar($conexion);
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
        <title>Login</title>
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
        <h1>Login</h1>
        <form method="post">
            <p>Usuario:
                <input type="text" id="usuario" name="usuario"
                       value="<?= $nombreLogin ?>" required>
            </p>
            <p>Contraseña:
                <input type="password" id="password" name="password" required>
            </p>
            <button type="submit" name="accion" value="iniciar">Entrar</button>
            <p style="color: red"><?= $msgError ?></p>
        </form>
        <button type="button" onclick="window.location.href='registro.php'">Registro</button>
    </body>
</html>