<!--Logica-->
<?php
    session_start();

    $colores = array("blue", "red", "green", "yellow", "orange", "pink", "purple", "gray");
    $coloresESP = array("Azul", "Rojo","Verde","Amarillo","Naranja","Rosa","Morado","Gris");
    $nCirculos = isset($_POST['nCirculos']) ? max(4, min(8, (int) $_POST['nCirculos'])) : 4;
    $nColores = isset($_POST['nColores']) ? max(4, min(8, (int) $_POST['nColores'])) : 4;

    if (isset($_POST['color_pulsado'])) {
        $colorPulsado = $_POST['color_pulsado'] ?? 'black';
    }

    function pintar_circulos(array $colores, int $nCirculos) {
        for ($k = 0; $k < $nCirculos; $k++) {
            $color = $colores[$k] ?? 'black';
            echo '<svg width="200" height="200">';
                echo '<circle cx="70" cy="70" r="70" fill="' . $color . '" />';
            echo '</svg>';
        }
    }

    function numero_colores(array $colores, int $nColores) {
        if ($nColores <= 0) {
            return array();
        }
        return array_slice($colores, 0, $nColores);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (($_POST['accion'] ?? '') === 'reiniciar') {
            session_destroy();
            unset($_SESSION['combinacion']);
        } elseif (isset($_POST['color_pulsado'])) {
            $colorPulsado = $_POST['color_pulsado'];

            if (in_array($colorPulsado, $colores)) {
                $_SESSION['jugada'][] = $colorPulsado;
            }
        } else {
            $_SESSION['combinacion'] = [];
            $coloresDisponibles = numero_colores($colores, $nColores);

            for ($k = 0; $k < $nCirculos; $k++) {
                $_SESSION['combinacion'][] = $coloresDisponibles[array_rand($coloresDisponibles)];
            }
            $_SESSION['jugada'] = [];
        }
    }
?>

<!--HTML-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Simon</title>
        <style>
            * {
                text-align:center;
            }
        </style>
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
        <?php pintar_circulos($_SESSION['combinacion'] ?? [], $nCirculos); ?>
        <br>

        <form method="post" id="form-colores">
            <input type="hidden" name="nCirculos" value="<?= $nCirculos ?>">
            <input type="hidden" name="nColores" value="<?= $nColores ?>">
            <?php for ($x = 0; $x <$nColores; $x++): ?>
                <button type="submit" name="color_pulsado" value="<?= $colores[$x]?>" style="background-color: <?= $colores[$x]?>;">
                    <?= $coloresESP[$x] ?>
                </button>
            <?php endfor; ?>
        </form>

        <br>
        <?php pintar_circulos($_SESSION['jugada'] ?? [], $nCirculos); ?>

        <?php
            $jugada = $_SESSION['jugada'] ?? [];
            $combinacion = $_SESSION['combinacion'] ?? [];
            if (count($combinacion) > 0 && count($jugada) === count($combinacion)) {
                echo $jugada === $combinacion ? '<p>Correcto</p>' : '<p>Incorrecto</p>';
            }
        ?>
    </body>
</html>