<!--LOGICA-->
<?php
    session_start();
    $usuarioEstatico = "pepe";
    $passwordEstatica = password_hash("1234", PASSWORD_DEFAULT);
    $usuario = $_SESSION['usuario'] ?? "";
    $password = $_SESSION['password'] ?? "";
    $msgError="";
    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (isset($_POST['usuario'], $_POST['password'])) {
        if($usuarioEstatico === $_POST['usuario'] && password_verify($_POST['password'], $passwordEstatica )) {
            header("Location: simon.php");
            exit;
        } else {
            $msgError="Fallaste";
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
                <input type="text" id="usuario" name="usuario" value="<?= $usuario ?>" required>
            </p>
            <p>Contraseña:
                <input type="password" id="password" name="password" value="<?= $password ?>" required>
            </p>
            <button type="submit" name="accion" value="iniciar">Entrar</button>
            <p style = "color : red"><?php echo"$msgError $passwordHash"?></p>
        </form>
        <button type="button" onclick="window.location.href='registro.php'">Registro</button>
    </body>
</html>