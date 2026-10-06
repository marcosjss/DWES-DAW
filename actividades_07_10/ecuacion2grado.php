<?php include 'matematicas.php'?>
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
        <p><?php echo"$r"?></p>
    </body>
</html>
