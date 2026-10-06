<?php
$r = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['a'], $_POST['b'], $_POST['c'])) {
    $a = (float) $_POST['a'];
    $b = (float) $_POST['b'];
    $c = (float) $_POST['c'];

    if ($a != 0) {
        $resultado = ecuacion($a, $b, $c);
    } else {
        $resultado = false;
    }

    if ($resultado === false) {
        $r = "La ecuación no tiene soluciones reales";
    } else {
        $r = "Valores ingresados: a = $a, b = $b, c = $c <br>";
        $r .= 'Resultado: x1 = ' . $resultado[0] . ', x2 = ' . $resultado[1];
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

function palindrono($cadena) {
    $cadena= strtolower(str_replace(' ', '', trim($cadena)));
    if ($cadena == strrev($cadena)) {
        return true;
    } else {
        return false;
    }
}

/*function limite {

}*/
