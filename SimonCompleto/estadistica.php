<?php
session_start();
require_once 'seguridad.php';
filtrar_acceso(false);

$conexion = require 'conexion.php';
$stmt = $conexion->query(
    'SELECT u.Codigo, u.Nombre, COALESCE(SUM(j.acierto), 0) AS aciertos
     FROM usuarios u
     LEFT JOIN jugadas j ON j.codigousu = u.Codigo
     GROUP BY u.Codigo, u.Nombre
     ORDER BY u.Codigo'
);
$estadisticas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Simon - Estadística</title>
        <style>
            * { text-align: center; }
            html {
                background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>
            }
            table { margin: 0 auto; border-collapse: collapse; }
            th, td { border: 1px solid black; padding: 4px 8px; }
            .barra { width: 150px; height: 8px; background: white; text-align: left; }
            .barra span { display: block; height: 8px; background: darkblue; }
        </style>
    </head>
    <body>
        <h2>SIMÓN - Estadísticas Globales</h2>
        <p><?= htmlspecialchars($_SESSION['usuario']['Nombre'], ENT_QUOTES, 'UTF-8') ?>, los resultados son:</p>
        <table>
            <thead>
                <tr>
                    <th>Cód.</th>
                    <th>Nombre</th>
                    <th>Aciertos</th>
                    <th>Gráfica</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estadisticas as $fila): ?>
                    <?php $ancho = min((int) $fila['aciertos'], 25) * 6; ?>
                    <tr>
                        <td><?= (int) $fila['Codigo'] ?></td>
                        <td><?= htmlspecialchars($fila['Nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $fila['aciertos'] ?></td>
                        <td><div class="barra"><span style="width: <?= $ancho ?>px;"></span></div></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="inicio.php">
            <button type="submit">Volver a jugar</button>
        </form>
        <form method="post" action="cierre.php">
            <button type="submit" name="accion" value="cerrar_sesion">Cerrar sesión</button>
        </form>
    </body>
</html>