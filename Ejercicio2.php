<?php
$alumnos = [
    ['nombre' => 'Ana', 'nota' => 8.5],
    ['nombre' => 'Pedro', 'nota' => 4.0],
    ['nombre' => 'Luis', 'nota' => 9.2],
    ['nombre' => 'María', 'nota' => 7.3],
    ['nombre' => 'Juan', 'nota' => 4.9],
    ['nombre' => 'Sofía', 'nota' => 6.0],
    ['nombre' => 'Carlos', 'nota' => 5.0]
];

$aprobados = array_filter($alumnos, fn($alumno) => $alumno['nota'] >= 5.0);

usort($aprobados, fn($a, $b) => $b['nota'] <=> $a['nota']);

$sumaTotal = array_reduce($alumnos, fn($carry, $alumno) => $carry + $alumno['nota'], 0);
$promedioGlobal = $sumaTotal / count($alumnos);
?>

<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Gestor de Calificaciones</h1>

    <h2>Ranking de Aprobados</h2>
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nombre</th>
                <th>Nota</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $posicion = 1;
            foreach ($aprobados as $alumno): 
            ?>
                <tr>
                    <td>#<?= $posicion++ ?></td>
                    <td><?= htmlspecialchars($alumno['nombre']) ?></td>
                    <td><?= number_format($alumno['nota'], 1) ?></td>
                    <td><span class="badge-success">Aprobado</span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Estadísticas Globales</h2>
    <table>
        <thead>
            <tr>
                <th>Métrica</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total de Alumnos Evaluados</td>
                <td><?= count($alumnos) ?> alumnos</td>
            </tr>
            <tr>
                <td>Total de Aprobados</td>
                <td><?= count($aprobados) ?> alumnos</td>
            </tr>
            <tr>
                <td>Suma Total de Calificaciones</td>
                <td><?= number_format($sumaTotal, 1) ?> puntos</td>
            </tr>
            <tr>
                <td><strong>Promedio Final del Grupo</strong></td>
                <td><strong><?= number_format($promedioGlobal, 2) ?> / 10.00</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>