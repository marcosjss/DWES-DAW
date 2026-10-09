<!--Logica-->
<?php
    session_start();

    $jugar = $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') !== 'reiniciar';

    $colores = array("blue", "red", "green", "yellow", "orange", "pink", "purple", "gray");
    $nCirculos = isset($_POST['nCirculos']) ? max(4, min(8, (int) $_POST['nCirculos'])) : 4;
    $nColores = isset($_POST['nColores']) ? max(4, min(8, (int) $_POST['nColores'])) : 4;

    function pintar_circulos(array $colores) {
        $color = $colores[array_rand($colores)];
        return $color;
    }

    function numero_colores(array $colores, int $nColores) {
        if ($nColores <= 0) {
            return array();
        }
        return array_slice($colores, 0, $nColores);
    }

    $_SESSION['combinacion'] = [];
    for ($k = 0; $k < $nCirculos; $k++) {
        $_SESSION['combinacion'][] = pintar_circulos(numero_colores($colores, $nColores));
    }
?>

<!--HTML-->
<!DOCTYPE html>
<html lang="es">
    <head>
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
            <button type="submit" name="accion" value="reiniciar">Volver a poner en negro</button>
        </form>
        <br>

        <?php for ($k = 0; $k < $nCirculos; $k++): ?>
            <svg width="200" height="200">
                <circle cx="70" cy="70" r="70" fill="<?= $jugar ? pintar_circulos(numero_colores($colores, $nColores)) : 'black' ?>" />
            </svg>  
        <?php endfor; ?>
    </body>
</html>