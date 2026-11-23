<!-- LOGICA -->
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
	header('Location: index.php');
	exit;
}

require_once 'conexion.php';

$stmt = $conexion->prepare(
	'SELECT u.codigo, u.nombre, COUNT(c.id) AS contactos, MAX(c.fecha) AS ultimo_alta
	 FROM usuarios u
	 LEFT JOIN contactos c ON c.codigousu = u.codigo
	 GROUP BY u.codigo, u.nombre
	 ORDER BY contactos DESC, u.codigo ASC'
);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as &$usuario) {
	$usuario['contactos'] = (int) $usuario['contactos'];
}
unset($usuario);

$totalAgenda = array_sum(array_column($usuarios, 'contactos'));
$maxContactos = $usuarios === [] ? 0 : max(array_column($usuarios, 'contactos'));
$codigoConectado = (int) $_SESSION['usuario']['codigo'];
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Totales de contactos</title>
	<style>
        * { text-align: center;}
        table {
            margin: 0 auto;
        }
        .grafica {
            background: grey;
            height: 16px;
            width: 100%;
        }

        .barra {
            background: darkblue;
            height: 100%;
        }
	</style>
</head>
<body>
	<h1>Agenda - Totales</h1>
    <p><?= $_SESSION['usuario']['nombre']?>, estos son los contactos guardados:</p>

	<table border="1">
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Contactos</th>
				<th>% sobre el total</th>
				<th>Último alta</th>
				<th>Gráfica</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($usuarios as $usuario): ?>
				<?php
					$porcentaje = $totalAgenda > 0
						? ($usuario['contactos'] / $totalAgenda) * 100
						: 0;
					$anchoBarra = $maxContactos > 0
						? ($usuario['contactos'] / $maxContactos) * 100
						: 0;
				?>
				<tr class="<?= (int) $usuario['codigo'] === $codigoConectado ? 'conectado' : '' ?>">
					<td><?= (int) $usuario['codigo'] ?></td>
					<td><?= $usuario['nombre'] ?></td>
					<td><?= $usuario['contactos'] ?></td>
					<td><?= number_format($porcentaje, 1, '.', '') ?>%</td>
					<td>
						<?= $usuario['ultimo_alta'] === null
							? '---------'
							: date('d/m/Y', strtotime($usuario['ultimo_alta'])) ?>
					</td>
					<td>
						<div class="grafica" role="img" aria-label="<?= $usuario['contactos'] ?> contactos">
							<div class="barra" style="width: <?= $anchoBarra ?>%"></div>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<a href="inicio.php">Grabar más contactos</a>
		<a href="cierre.php?accion=cerrar_sesion">Cerrar sesión</a>
    </div>
</body>
</html>

