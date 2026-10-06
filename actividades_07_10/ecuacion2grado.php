<?php include 'matematicas.php';?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h3>x = (-b +- √(b²-4ac)) / 2a </h3>
        <form method="post">
            <input type="number" name="a" placeholder="a" required>
            <input type="number" name="b" placeholder="b" required>
            <input type="number" name="c" placeholder="c" required>
            <button type="submit">Calcular</button>
        </form>
        <p><?php echo $r; ?></p>
        <br>
        <h3>Palíndromo</h3>
        <form method="post">
            <input type="text" name="cadena" placeholder="Ingrese una cadena" required>
            <button type="submit">Verificar</button>
        </form>
        <p>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadena'])) {
                $cadena = $_POST['cadena'];
                if (palindrono($cadena)) {
                    echo "La cadena '$cadena' es un palíndromo.";
                } else {
                    echo "La cadena '$cadena' no es un palíndromo.";
                }
            }
            ?>
        </p>
    </body>
</html>
