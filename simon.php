<!--HTML-->
<!--Pantalla seleccion nivel de dificultad elegir numero de circulo entre 4 y 8 y el numero de colores se puede seleccionar entre 4 a 8 colores-->
<?php
    $colores = array("blue", "red", "green", "yellow", "orange", "pink", "purple", "gray");
    $nCirculos = isset($_POST['nCirculos']) ? (int) $_POST['nCirculos'] : 4;
    $nColores = isset($_POST['nColores']) ? (int) $_POST['nColores'] : 4;
//Logica
function pintar_circulos(array $colores, int $nCirculos) {
    $color = $colores[array_rand($colores)];
    return $color;
}

function numero_colores(array $colores, int $nColores) {
    if ($nColores <= 0) {
        return array();
    }
    return array_slice($colores, 0, $nColores);
}

//function seleccionar_color(array $colores, int $nCirculos) {

//}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <include src="simon.php">
        <meta charset="UTF-8">
        <title>Simon</title>
    </head>
    <body>
        <form method ="post">
            <p for="nCirculos">Número de círculos (4-8):
            <input type="number" id="nCirculos" name="nCirculos" min="4" max="8" value="<?= $nCirculos ?>"></p>
            <br>
            <p for="nColores">Número de colores (4-8):
            <input type="number" id="nColores" name="nColores" min="4" max="8" value="<?= $nColores ?>"></p>
            <br>
            <input type="submit" value="Jugar">
        </form>

        <?php for ($k = 0; $k < $nCirculos; $k++): ?>
            <svg width="200" height="200">
                <circle cx="70" cy="70" r="70" fill="<?= pintar_circulos(numero_colores($colores, $nColores), $nCirculos) ?>" />
            </svg>
        <?php endfor; ?>
        <br>
        <?php for ($k = 0; $k < $nCirculos; $k++): ?>
            <svg width="200" height="200">
                <circle cx="70" cy="70" r="70" fill="" />
            </svg>
            <select id="seleccion" name="seleccion">
                <?php foreach (numero_colores($colores, $nColores) as $color): ?>
                    <option value="<?= $color ?>"><?= ucfirst($color) ?></option>
                <?php endforeach; ?>
            </select>
        <?php endfor; ?>
    </body>
</html>

