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
    </body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = (float) $_POST['a'];
    $b = (float) $_POST['b'];
    $c = (float) $_POST['c'];

    if ($a != 0) {
        $resultado = ecuacion($a, $b, $c);
    } else {
        $resultado = false;
    }

    if ($resultado === false) {
        echo "La ecuación no tiene soluciones reales";
    } else {
        echo "Valores ingresados: a = $a, b = $b, c = $c <br>";
        echo 'Resultado: x1 = ' . $resultado[0] . ', x2 = ' . $resultado[1];
    }
}

function ecuacion($a, $b, $c) {
    $raiz = ($b * $b) - (4 * $a * $c);
    if ($raiz < 0) {
        return false;
    }

    $x1 = (-$b + sqrt($raiz)) / (2 * $a);
    $x2 = (-$b - sqrt($raiz)) / (2 * $a);

    return [$x1, $x2];
}
