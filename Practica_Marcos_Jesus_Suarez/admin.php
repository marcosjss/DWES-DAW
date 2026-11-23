<!-- LOGICA -->
<?php
    session_start();
    require_once 'conexion.php';
    require_once 'seguridad.php';
    filtrar_acceso(true);

    //Carga la primera vez para que no salgan vacios los campos
    $stmt = $conexion->prepare(
    'SELECT max_lote, num_emojis, max_contactos
     FROM configuracion
     WHERE id = 1'
    );
    $stmt->execute();
    $configuracion = $stmt->fetch(PDO::FETCH_ASSOC);

    $max_lote = $configuracion['max_lote'];
    $num_emojis = $configuracion['num_emojis'];
    $max_contactos = $configuracion['max_contactos'];

    //Actualizar form
    if (isset($_POST['max_lote'], $_POST['num_emojis'], $_POST['max_contactos'])) {
        $max_lote = $_POST['max_lote'];
        $num_emojis = $_POST['num_emojis'];
        $max_contactos = $_POST['max_contactos'];

        if ($max_lote >= 3 && $max_lote <= 8 &&
            $num_emojis >= 4 && $num_emojis <= 10 &&
            $max_contactos >= 10 && $max_contactos <=100) {
        $stmt = $conexion->prepare(
            'UPDATE configuracion SET max_lote = ?, num_emojis = ?, max_contactos = ? WHERE id = 1'
        );
        $stmt->execute([$max_lote, $num_emojis, $max_contactos]);
        }
    }
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <style>
            * { text-align: center; }
            table {
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <h1>Panel de administracion</h1>
        <h3>Conectado como Administrador: <?= $_SESSION['usuario']['nombre'] ?? '' ?></h3>
        <form method="post" action="cierre.php">
            <button type="submit" name="accion" value="cerrar_sesion">Cerrar sesión</button>
        </form>
        <form method="post">
            <p>Contactos por lote (3-8):
                <input type="number" id="max_lote" name="max_lote" min="3" max="8" value="<?= $max_lote ?>" required>
            </p>
            <p>Emojis disponibles (4-10):
                <input type="number" id="num_emojis" name="num_emojis" min="4" max="10" value="<?= $num_emojis ?>" required>
            </p>
            <p>Maximo de contactos (10-100):
                <input type="number" id="max_contactos" name="max_contactos" min="10" max="100" value="<?= $max_contactos ?>" required>
            </p>
            <button type="submit">Guardar</button>
        </form>
        <br>
        <!-- Consulta y tabla de usuarios -->
        <?php
            $sql = '
                SELECT u.codigo, u.nombre, u.rol, COUNT(c.id) AS num_contactos
                FROM usuarios u
                LEFT JOIN contactos c ON c.codigousu = u.codigo
                GROUP BY u.codigo, u.nombre, u.rol
                ORDER BY u.codigo
            ';

            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table border="1">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Número de contactos</th>
            </tr>

            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['codigo']?></td>
                    <td><?= $usuario['nombre']?></td>
                    <td><?= $usuario['rol']?></td>
                    <td><?= $usuario['num_contactos']?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>