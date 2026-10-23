<!--Logica-->
<?php include "logica.php";?>
<?php /*$conexion=*/include "conexion.php";?>
<?php include "cierre.php";?>

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
            html {
                //background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>;
                background-color: <?= $colorFondo ?>;
            }
            
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            table {
                margin: auto;
            }
        </style>
    </head>
    <body>
        <?php if ($fase === 'configuracion'): ?>
            <h1>Simon</h1>
            <form method="post">
                <p>Número de círculos (4-8):
                    <input type="number" id="nCirculos" name="nCirculos" min="4" max="8" value="<?= $nCirculos ?>" required>
                </p>
                <p>Número de colores (4-8):
                    <input type="number" id="nColores" name="nColores" min="4" max="8" value="<?= $nColores ?>" required>
                </p>
                <button type="submit" name="accion" value="iniciar">Empezar</button>
            </form>
            <form method="post">
                <p>Color de fondo
                    <input name="cColor" required></input>
                    <button type="submit" name="accion" value="fondo">Cambiar color </button>
                </p>
            </form>

        <?php elseif ($fase === 'memorizacion'): ?>
            <h1>Combinacion generada:</h1>
            <?php pintar_circulos($_SESSION['combinacion'] ?? [], $nCirculos); ?>
            <form method="post">
                <button type="submit" name="accion" value="comenzar_juego">Empezar juego</button>
            </form>

        <?php elseif ($fase === 'juego'): ?>
            <h1>Introduce la combinación</h1>
            <?php pintar_circulos($_SESSION['jugada'] ?? [], $nCirculos); ?>
            <form method="post" id="form-colores">
                <?php for ($x = 0; $x < $nColores; $x++): ?>
                    <button type="submit" name="color_pulsado" value="<?= $colores[$x] ?>" style="background-color: <?= $colores[$x] ?>;">
                        <?= $coloresESP[$x] ?>
                    </button>
                <?php endfor; ?>
            </form>

        <?php else: ?>
            <?php
                $jugada = $_SESSION['jugada'] ?? [];
                $combinacion = $_SESSION['combinacion'] ?? [];
            ?>
            <h1>Resultado</h1>
            <p>Combinación correcta:</p>
            <?php pintar_circulos($combinacion, $nCirculos); ?>

            <p>Tu combinación:</p>
            <?php pintar_circulos($jugada, $nCirculos); ?>

            <p><?= $jugada === $combinacion ? 'Correcto' : 'Incorrecto' ?></p>
            <form method="post">
                <button type="submit" name="accion" value="reiniciar">Volver a empezar</button>
            </form>
        <?php endif; ?>
    </body>
</html>